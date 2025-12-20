<?php

declare(strict_types=1);

namespace Configurator;

use Configurator\Structure\Src;
use Configurator\Structure\Docs;
use Configurator\Structure\Test;
use Configurator\Structure\Route;
use Configurator\Structure\Tools;
use Configurator\Structure\Config;
use Configurator\Structure\GitHub;
use Configurator\PrompterInterface;
use Configurator\Structure\Composer;
use Configurator\Structure\Database;
use Configurator\Structure\Resource;
use Configurator\ConfiguratorPrompter;
use Configurator\Structure\PackageJson;

final class PackageConfigurator
{
    public string $authorName = '';
    public string $authorEmail = '';
    public string $authorUsername = '';
    public string $className = '';
    public string $description = '';
    public string $laravelVersion = '';
    public string $license = '';
    public string $packageSlug = '';
    public string $phpVersion = '';
    public string $routeType = '';
    public string $vendorName = '';
    public string $vendorNamespace = '';
    public string $vendorSlug = '';
    public bool $includeAssets = Resource::IS_ASSETS_INCLUDED;
    public bool $includeCommand = Src::IS_COMMAND_INCLUDED;
    public bool $includeConfig = Config::IS_CONFIG_INCLUDED;
    public bool $includeFacade = Src::IS_FACADE_INCLUDED;
    public bool $includeFunding = GitHub::IS_FUNDING_INCLUDED;
    public bool $includeMigration = Database::IS_MIGRATION_INCLUDED;
    public bool $includeRoutes = Route::IS_ROUTES_INCLUDED;
    public bool $includeTests = Test::IS_TESTS_INCLUDED;
    public bool $includeTranslations = Resource::IS_TRANSLATIONS_INCLUDED;
    public bool $includeViews = Resource::IS_VIEWS_INCLUDED;
    public bool $includeWorkflow = false;
    public bool $useCommitLint = PackageJson::IS_COMMITLINT_INCLUDED;
    public bool $usePint = Tools::IS_PINT_ENABLED;
    public bool $usePhpStan = Tools::IS_PHP_STAN_INCLUDED;
    public bool $useRector = Tools::IS_RECTOR_INCLUDED;
    public bool $usePsalm = Tools::IS_PSALM_INCLUDED;

    private string $basePath = '';
    private string $packageName = '';
    private string $packageSlugUnderscored = '';
    private string $variableName = '';

    private PrompterInterface $prompter;

    public function __construct(?PrompterInterface $prompter = null)
    {
        $this->prompter = $prompter ?: new ConfiguratorPrompter();
    }

    public function run(?string $basePath = null): void
    {
        if ($basePath !== null) {
            ConfiguratorGlobals::setBasePath($basePath);
        }
        $this->basePath = ConfiguratorGlobals::getBasePath();

        ConfiguratorOutput::printHeader();

        ConfiguratorOutput::printAuthorInformation();
        $this->collectAuthorInfo();

        ConfiguratorOutput::printPackageInformation();
        $this->collectPackageInfo();

        ConfiguratorOutput::printVersionRequirements();
        $this->collectVersionRequirements();

        ConfiguratorOutput::printFeatureSelections();
        $this->collectFeatureSelections();

        ConfiguratorOutput::printDevToolSelections();
        $this->collectDevToolSelections();

        ConfiguratorOutput::printSummary($this);
        if (!$this->prompter->promptProceed()) {
            exit(1);
        }

        ConfiguratorOutput::printFinalizingMessage();

        $this->processStubsAndFiles();

        $this->updateComposerJson();
        $this->updateReadmeFile();
        $this->updateServiceProviderFile();

        $this->updateWorkflowFile();
        $this->createAdditionalDirectories();
        $this->handleDevTools();
        $this->finalizeAndCleanup();
    }

    /**
     * Collect author information.
     *
     * Author information includes name, email, and username.
     */
    public function collectAuthorInfo(): void
    {
        $this->authorName = $this->prompter->promptAuthorName();
        $this->authorEmail = $this->prompter->promptAuthorEmail();
        $this->authorUsername = $this->prompter->promptAuthorUsername();
    }

    /**
     * Collect package information.
     *
     * Package information includes vendor name, package name, class name, description, and license.
     */
    public function collectPackageInfo(): void
    {
        // Vendor info
        $this->vendorName = $this->prompter->promptVendorName($this->authorUsername);
        $this->vendorSlug  = ConfigUtil::slug($this->vendorName);
        $this->vendorNamespace = $this->prompter->promptVendorNamespace(ucwords($this->vendorName));

        $currentDirectory = getcwd();
        $folderName = is_string($currentDirectory) ? basename($currentDirectory) : 'my-package';

        // Package info
        $this->packageName = $this->prompter->promptPackageName($folderName);
        $this->packageSlug = ConfigUtil::slug($this->packageName);
        $this->packageSlugUnderscored = ConfigUtil::slug($this->packageName, '_');

        // Class name
        $this->className = $this->prompter->promptClassName(ConfigUtil::titleCase($this->packageName));
        $this->variableName = lcfirst($this->className);
        // Description
        $this->description = $this->prompter->promptDescription("This is my package {$this->packageName}");
        // License
        $this->license = $this->prompter->promptLicense();
        // Funding
        $this->includeFunding = $this->prompter->promptIncludeFunding();
    }

    /**
     * Collect version requirements.
     *
     * Version requirements include PHP version and Laravel version.
     */
    public function collectVersionRequirements(): void
    {
        $this->phpVersion = $this->prompter->promptPhpVersion();
        $this->laravelVersion = $this->prompter->promptLaravelVersion();
    }

    /**
     * Collect feature selections.
     *
     * Feature selections include migration, config, routes, tests, views, translations, assets, command, and facade.
     */
    public function collectFeatureSelections(): void
    {
        $this->includeMigration = $this->prompter->promptIncludeMigration();
        $this->includeConfig = $this->prompter->promptIncludeConfig();

        $this->includeRoutes = $this->prompter->promptIncludeRoutes();
        $this->routeType = 'none';
        if ($this->includeRoutes) {
            $this->routeType = $this->prompter->promptRouteType();
        }

        $this->includeTranslations = $this->prompter->promptIncludeTranslations();
        $this->includeAssets = $this->prompter->promptIncludeAssets();
        $this->includeViews = $this->prompter->promptIncludeViews();
        $this->includeCommand = $this->prompter->promptIncludeCommand();
        $this->includeFacade = $this->prompter->promptIncludeFacade();
        $this->includeTests = $this->prompter->promptIncludeTests();
    }

    /**
     * Collect development tool selections.
     *
     * Development tool selections include Pint, PHPStan, and Rector.
     */
    public function collectDevToolSelections(): void
    {
        $this->useCommitLint = $this->prompter->promptEnableCommitLint();
        $this->usePint = $this->prompter->promptEnablePint();
        $this->usePhpStan = $this->prompter->promptEnablePhpStan();
        $this->usePsalm = $this->prompter->promptEnablePsalm();
        $this->useRector = $this->prompter->promptEnableRector();
    }

    /**
     * Process stub files and other necessary files.
     *
     * This includes copying stub files to their destinations and replacing placeholders with actual values.
     */
    protected function processStubsAndFiles(): void
    {
        // Php versions array
        $phpVersions = str_replace('^', '', $this->phpVersion); // e.g. "8.2|8.3" or "8.2"
        $phpVersionsArr = explode('|', $phpVersions);

        // Testbench version
        $testbenchVersion = Composer::getTestbenchVersion($this->laravelVersion);

        // Laravel version number
        $laravelVerNum = str_replace('^', '', $this->laravelVersion);

        // PHPStan job
        $phpstanJob = '';
        if ($this->usePhpStan) {
            $phpstanJob = Tools::PHP_STAN_JOB;
        }

        // Pint job
        $pintJob = '';
        if ($this->usePint) {
            $pintJob = Tools::PINT_JOB;
        }

        // Psalm jib
        $psalmJob = '';
        if ($this->usePsalm) {
            $psalmJob = Tools::PSALM_JOB;
        }

        // Copy stub files to their destination and replace placeholders
        $stubMappings = $this->getStubMappings();
        foreach ($stubMappings as $stubFile => [$dest, $folder]) {
            if (file_exists($stubFile)) {
                $copied = ConfigUtil::copyFileToDestination($stubFile, $dest, $folder);
                if ($copied) {
                    ConfigUtil::replaceInFile($dest, [
                        ':author_name' => $this->authorName,
                        ':author_username' => $this->authorUsername,
                        ':author_email' => $this->authorEmail,
                        ':vendor_name' => $this->vendorName,
                        ':vendor_slug' => $this->vendorSlug,
                        ':package_name' => $this->packageName,
                        ':package_slug_upper_' => strtoupper($this->packageSlugUnderscored) . '_',
                        ':package_slug_underscored' => $this->packageSlugUnderscored,
                        ':package_slug' => $this->packageSlug,
                        ':package_description' => $this->description,
                        ':composer_namespace' => "{$this->vendorNamespace}\\\\{$this->className}",
                        ':namespace' => "{$this->vendorNamespace}\\{$this->className}",
                        ':class_name' => $this->className,
                        ':service_provider_name' => "{$this->className}ServiceProvider",
                        ':variable' => $this->variableName,
                        ':php_version_comma_separated' => implode(', ', $phpVersionsArr),
                        ':php_version' => $this->phpVersion,
                        ':laravel_version' => $this->laravelVersion,
                        ':laravel_version_number' => $laravelVerNum,
                        ':testbench_version' => $testbenchVersion,
                        ':phpstan_job' => $phpstanJob,
                        ':pint_job' => $pintJob,
                        ':psalm_job' => $psalmJob,
                        ':license' => $this->license,
                        ':code_quality_tools' => $this->getCodeQualityTools(),
                        ':command_class' => $this->includeCommand
                            ? "\\{$this->vendorNamespace}\\{$this->className}\\Commands\\{$this->className}Command::class"
                            : '',
                    ]);
                } elseif ($dest) {
                    ConfigUtil::writeln("Warning: Failed to copy $stubFile to $dest");
                }
            }
        }
    }

    /**
     * Update the composer.json file with collected information.
     */
    private function updateComposerJson(): void
    {
        $data = Composer::getComposerJson();
        if (isset($data['require']) && is_array($data['require'])) {
            $data['require']['php'] = $this->phpVersion;
            $data['require']['illuminate/contracts'] = $this->laravelVersion;
        }
        $data['license'] = $this->license;
        Composer::updateComposerJson($data);
    }

    /**
     * Update the service provider file based on selected features.
     */
    private function updateServiceProviderFile(): void
    {
        $serviceProviderPath = Src::getPath() . '/' . $this->className . 'ServiceProvider.php';
        ConfigUtil::processConditionalBlocks(
            $serviceProviderPath,
            [
                'include_command'   => $this->includeCommand,
                'include_config'    => $this->includeConfig,
                'include_migration' => $this->includeMigration,
                'include_translations' => $this->includeTranslations,
                'include_views'     => $this->includeViews,
                'include_api_routes' => $this->includeRoutes && ($this->routeType === 'api' || $this->routeType === 'both'),
                'include_web_routes' => $this->includeRoutes && ($this->routeType === 'web' || $this->routeType === 'both'),
            ]
        );
    }

    /**
     * Update the README.md file based on selected features.
     */
    private function updateReadmeFile(): void
    {
        $isCodeQualityToolSelected = $this->isCodeQualityToolSelected();
        ConfigUtil::processConditionalBlocks(
            $this->basePath . '/' . Docs::README_FILE_NAME,
            [
                'include_config'    => $this->includeConfig,
                'include_facade'    => $this->includeFacade,
                'include_migration' => $this->includeMigration,
                'include_command'   => $this->includeCommand,
                'include_tests'     => $this->includeTests,
                'include_workflow'   => $this->includeTests || $isCodeQualityToolSelected,
                'include_code_quality_tools' => $isCodeQualityToolSelected,
            ]
        );
    }

    /**
     * Update the GitHub workflow file based on selected features.
     */
    private function updateWorkflowFile(): void
    {
        if ($this->includeWorkflow) {
            ConfigUtil::processConditionalBlocks(
                GitHub::getWorkflowFilePath(),
                [
                    'include_tests' => $this->includeTests,
                ]
            );
        }
    }

    /**
     * Create additional directories and files based on selected features.
     *
     * This includes assets, views, and routes.
     */
    private function createAdditionalDirectories(): void
    {
        if ($this->includeAssets) {
            ConfigUtil::createDirectoryIfNotExists(Resource::getPath());

            Resource::createCssFile();
            Resource::createJsFile();
        }

        if ($this->includeTranslations) {
            Resource::createLangFile();
        }

        if ($this->includeRoutes) {
            ConfigUtil::createDirectoryIfNotExists(Route::getPath());

            if ($this->routeType === 'web' || $this->routeType === 'both') {
                Route::createWebFile();
            }
            if ($this->routeType === 'api' || $this->routeType === 'both') {
                Route::createApiFile();
            }
        }

        if ($this->includeViews) {
            ConfigUtil::createDirectoryIfNotExists(Resource::getViewsPath());
        }
    }

    /**
     * Handle development tool setup based on selections.
     *
     * This includes setting up PHPStan, Pint, and Rector.
     */
    private function handleDevTools(): void
    {
        Tools::setupPhpStan($this->usePhpStan);
        Tools::setupPint($this->usePint);
        Tools::setupPsalm($this->usePsalm);
        Tools::setupRector($this->useRector);
    }

    /**
     * Finalize the setup process and perform cleanup if selected.
     *
     * This includes running composer install and deleting configurator files if they are no longer needed.
     */
    private function finalizeAndCleanup(): void
    {
        if ($this->prompter->promptComposerInstall()) {
            ConfiguratorOutput::printRunningComposerMessage();
            // First remove the vendor directory to ensure a clean install
            if (is_dir($this->basePath . '/vendor')) {
                ConfigUtil::deleteFolderRecursively($this->basePath . '/vendor');
            }
            // Remove the composer.lock file if it exists
            ConfigUtil::deleteFileIfExists($this->basePath . '/composer.lock');

            exec('composer install');
            if ($this->usePsalm) {
                exec('./vendor/bin/psalm --init');
            }

            if ($this->useCommitLint) {
                ConfigUtil::deleteFolderRecursively($this->basePath . '/node_modules');
                ConfigUtil::deleteFileIfExists($this->basePath . '/package-lock.json');
                exec('npm install');
            }
        }

        ConfiguratorOutput::printCompletionMessage();
        ConfiguratorOutput::printCompletionInstructions($this);

        if ($this->prompter->promptCleanup()) {
            ConfigUtil::deleteFolderRecursively($this->basePath . '/configurator');

            ConfigUtil::deleteFileIfExists($this->basePath . '/configure.php');
            ConfigUtil::deleteFileIfExists($this->basePath . '/CONFIGURATION.md');
            ConfigUtil::deleteFileIfExists($this->basePath . '/.php-cs-fixer.dist.php');
            ConfigUtil::deleteFileIfExists($this->basePath . '/.php-cs-fixer.cache');
            ConfigUtil::deleteFileIfExists($this->basePath . '/.phpunit.result.cache');
            ConfigUtil::deleteFileIfExists($this->basePath . '/tests/Unit/PackageConfiguratorTest.php');
            ConfigUtil::deleteFileIfExists($this->basePath . '/tests/TestPrompter.php');

            if (!$this->usePhpStan) {
                ConfigUtil::deleteFileIfExists($this->basePath . '/phpstan.neon');
            }

            if (!$this->usePint) {
                ConfigUtil::deleteFileIfExists($this->basePath . '/pint.json');
            }

            if (!$this->useRector) {
                ConfigUtil::deleteFileIfExists($this->basePath . '/rector.php');
            }

            if (!$this->usePsalm) {
                ConfigUtil::deleteFileIfExists($this->basePath . '/psalm.xml');
            }

            if (!$this->useCommitLint) {
                ConfigUtil::deleteFileIfExists(PackageJson::getFilePath());
                ConfigUtil::deleteFileIfExists($this->basePath . '/package-lock.json');
                ConfigUtil::deleteFolderRecursively($this->basePath . '/.husky');
            }

            ConfiguratorOutput::printCleanupMessage();
        }
    }

    /**
     * Get a comma-separated string of selected code quality tools.
     *
     * @return string The selected code quality tools
     */
    private function getCodeQualityTools(): string
    {
        $tools = [];
        if ($this->usePhpStan) {
            $tools[] = 'Larastan';
        }
        if ($this->usePint) {
            $tools[] = 'Laravel Pint';
        }
        if ($this->usePsalm) {
            $tools[] = 'Psalm';
        }
        if ($this->useRector) {
            $tools[] = 'Rector';
        }

        return implode(', ', $tools);
    }

    /**
     * Get the mapping of stub files to their destination paths.
     *
     * @return array<string, array{0: string, 1: ?string}> The mapping of stub files to destination paths
     */
    private function getStubMappings(): array
    {
        $srcPath = Src::getPath();
        $maps = [
            Composer::STUB => [Composer::getFilePath(), null],
            Docs::CHANGELOG_STUB => [$this->basePath . '/' . Docs::CHANGELOG_FILE_NAME, null],
            Docs::LICENSE_STUB => [$this->basePath . '/' . Docs::LICENSE_FILE_NAME, null],
            Docs::README_STUB => [$this->basePath . '/' . Docs::README_FILE_NAME, null],
            Src::SERVICE_PROVIDER_STUB => [$srcPath . '/' . $this->className . 'ServiceProvider.php', $srcPath],
        ];

        if ($this->includeCommand) {
            $commandPath = Src::getCommandsPath();
            $maps[Src::COMMAND_STUB] = [
                $commandPath . '/' . $this->className . 'Command.php',
                $commandPath,
            ];
        }

        if ($this->includeConfig) {
            $configPath = Config::getPath();
            $maps[Config::STUB] = [
                $configPath . '/' . $this->packageSlug . '.php',
                $configPath,
            ];
        }

        if ($this->includeFacade) {
            $facadePath = Src::getFacadesPath();
            $maps[Src::FACADE_STUB] = [
                $facadePath . '/' . $this->className . 'Facade.php',
                $facadePath,
            ];
        }

        if ($this->includeMigration) {
            $migrationPath = Database::getMigrationPath();
            $maps[Database::MIGRATION_STUB] = [
                $migrationPath . '/create_' . $this->packageSlugUnderscored . '_table.php',
                $migrationPath,
            ];
        }

        if ($this->includeTests) {
            $testPath = Test::getPath();
            $featureTestPath = Test::getFeatureTestsPath();
            $unitTestPath = Test::getUnitTestsPath();
            $this->includeWorkflow = true;
            $maps = array_merge($maps, [
                Test::FEATURE_TEST_STUB => [$featureTestPath . '/' . Test::FEATURE_TEST_FILE_NAME, $featureTestPath],
                Test::PEST_STUB => [$testPath . '/' . Test::PEST_FILE_NAME, $testPath],
                Test::PHPUNIT_STUB => [$this->basePath . '/' . Test::PHP_UNIT_FILE_NAME, null],
                Test::TESTCASE_STUB => [$testPath . '/' . Test::TESTCASE_FILE_NAME, $testPath],
                Test::UNIT_TEST_STUB => [$unitTestPath . '/' . Test::UNIT_TEST_FILE_NAME, $unitTestPath],
            ]);
        }

        if ($this->includeWorkflow || $this->isCodeQualityToolSelected()) {
            $this->includeWorkflow = true;
            $maps[GitHub::WORKFLOW_STUB] = [GitHub::getWorkflowFilePath(), GitHub::getWorkflowsPath()];
        }

        if ($this->includeFunding) {
            $maps[GitHub::FUNDING_STUB] = [GitHub::getPath() . '/' . GitHub::FUNDING_FILE_NAME, GitHub::getPath()];
        }

        if ($this->useCommitLint) {
            $maps[PackageJson::STUB] = [PackageJson::getFilePath(), null];
            $maps[PackageJson::STUB_COMMIT_LINT_CONFIG] = [
                PackageJson::getCommitLintFilePath(),
                null,
            ];
        }

        return $maps;
    }

    /**
     * Determine if any code quality tool is selected.
     *
     * @return bool True if any code quality tool is selected, false otherwise
     */
    private function isCodeQualityToolSelected(): bool
    {
        return $this->usePhpStan || $this->usePint || $this->useRector;
    }
}
