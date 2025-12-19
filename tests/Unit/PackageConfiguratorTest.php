<?php

declare(strict_types=1);

namespace Tests\Unit;

use SplFileInfo;
use FilesystemIterator;
use Tests\TestPrompter;
use RecursiveIteratorIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use Configurator\PackageConfigurator;

/** @psalm-suppress UnusedClass */
final class PackageConfiguratorTest extends TestCase
{
    /** @var string */
    private string $tempDir = '';

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        // Create a test output directory inside the package for easier inspection and cleanup
        $this->tempDir = __DIR__ . '/../generated-test';
        if (is_dir($this->tempDir)) {
            $this->deleteDir($this->tempDir);
        }

        $this->createDir($this->tempDir);
    }

    #[\Override]
    protected function tearDown(): void
    {
        // Recursively delete the test output directory after each test
        $this->deleteDir($this->tempDir);
        parent::tearDown();
    }

    /**
     * Ensure every configuration variation is tested and config files are generated as expected.
     *
     * This test will:
     * 1. Check that all variations in configurationVariations are tested.
     * 2. For each variation, run the configurator and check for config file presence/absence.
     */
    public function testConfigurationVariations(): void
    {
        $variations = self::configurationVariations();
        $tested = 0;
        foreach ($variations as $variationName => $expected) {
            $tested++;
            // Clean output dir
            if (is_dir($this->tempDir)) {
                $this->deleteDir($this->tempDir);
            }
            $this->createDir($this->tempDir);

            // Use TestPrompter to simulate prompt answers
            $prompter = new TestPrompter($expected);
            $configurator = new PackageConfigurator($prompter);

            // Run the generator with the temp dir as base path
            $configurator->run($this->tempDir);

            $package = isset($expected['package_name']) && is_string($expected['package_name'])
                ? strtolower($expected['package_name'])
                : 'config';

            // Config file
            $configFile = $this->tempDir . "/config/{$package}.php";
            if (isset($expected['include_config']) && $expected['include_config'] === true) {
                $this->assertFileExists($configFile, "Config file should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($configFile, "Config file should NOT exist for variation: $variationName");
            }

            // Migration
            $migrationFile = $this->tempDir . "/database/migrations/create_{$package}_table.php";
            if (isset($expected['include_migration']) && $expected['include_migration'] === true) {
                $this->assertFileExists($migrationFile, "Migration file should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($migrationFile, "Migration file should NOT exist for variation: $variationName");
            }

            // Routes
            $webRoute = $this->tempDir . "/routes/web.php";
            $apiRoute = $this->tempDir . "/routes/api.php";
            if (isset($expected['include_routes']) && $expected['include_routes'] === true) {
                if (isset($expected['route_type']) && ($expected['route_type'] === 'web' || $expected['route_type'] === 'both')) {
                    $this->assertFileExists($webRoute, "Web route should exist for variation: $variationName");
                } else {
                    $this->assertFileDoesNotExist($webRoute, "Web route should NOT exist for variation: $variationName");
                }
                if (isset($expected['route_type']) && ($expected['route_type'] === 'api' || $expected['route_type'] === 'both')) {
                    $this->assertFileExists($apiRoute, "API route should exist for variation: $variationName");
                } else {
                    $this->assertFileDoesNotExist($apiRoute, "API route should NOT exist for variation: $variationName");
                }
            } else {
                $this->assertFileDoesNotExist($webRoute, "Web route should NOT exist for variation: $variationName");
                $this->assertFileDoesNotExist($apiRoute, "API route should NOT exist for variation: $variationName");
            }

            // Translations
            $translationFile = $this->tempDir . "/resources/lang/en/messages.php";
            if (isset($expected['include_translations']) && $expected['include_translations'] === true) {
                $this->assertFileExists($translationFile, "Translation file should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($translationFile, "Translation file should NOT exist for variation: $variationName");
            }

            // Assets
            $cssDir = $this->tempDir . "/resources/css";
            $jsDir = $this->tempDir . "/resources/js";
            if (isset($expected['include_assets']) && $expected['include_assets'] === true) {
                $this->assertDirectoryExists($cssDir, "CSS directory should exist for variation: $variationName");
                $this->assertDirectoryExists($jsDir, "JS directory should exist for variation: $variationName");
            } else {
                $this->assertDirectoryDoesNotExist($cssDir, "CSS directory should NOT exist for variation: $variationName");
                $this->assertDirectoryDoesNotExist($jsDir, "JS directory should NOT exist for variation: $variationName");
            }

            // Views
            $viewsDir = $this->tempDir . "/resources/views";
            if (isset($expected['include_views']) && $expected['include_views'] === true) {
                $this->assertDirectoryExists($viewsDir, "Views directory should exist for variation: $variationName");
            } else {
                $this->assertDirectoryDoesNotExist($viewsDir, "Views directory should NOT exist for variation: $variationName");
            }

            // Command
            $commandFile = $this->tempDir . "/src/Commands/{$expected['class_name']}Command.php";
            if (isset($expected['include_command']) && $expected['include_command'] === true) {
                $this->assertFileExists($commandFile, "Command file should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($commandFile, "Command file should NOT exist for variation: $variationName");
            }

            // Facade
            $facadeFile = $this->tempDir . "/src/Facades/{$expected['class_name']}Facade.php";
            if (isset($expected['include_facade']) && $expected['include_facade'] === true) {
                $this->assertFileExists($facadeFile, "Facade file should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($facadeFile, "Facade file should NOT exist for variation: $variationName");
            }

            // Tests
            $featureTest = $this->tempDir . "/tests/Feature/ExampleTest.php";
            $unitTest = $this->tempDir . "/tests/Unit/ExampleTest.php";
            if (isset($expected['include_tests']) && $expected['include_tests'] === true) {
                $this->assertFileExists($featureTest, "Feature test should exist for variation: $variationName");
                $this->assertFileExists($unitTest, "Unit test should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($featureTest, "Feature test should NOT exist for variation: $variationName");
                $this->assertFileDoesNotExist($unitTest, "Unit test should NOT exist for variation: $variationName");
            }

            // Pint
            $pintFile = $this->tempDir . "/pint.json";
            if (isset($expected['use_pint']) && $expected['use_pint'] === true) {
                $this->assertFileExists($pintFile, "Pint config should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($pintFile, "Pint config should NOT exist for variation: $variationName");
            }

            // PhpStan
            $phpstanFile = $this->tempDir . "/phpstan.neon";
            if (isset($expected['use_phpstan']) && $expected['use_phpstan'] === true) {
                $this->assertFileExists($phpstanFile, "PhpStan config should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($phpstanFile, "PhpStan config should NOT exist for variation: $variationName");
            }

            // Rector
            $rectorFile = $this->tempDir . "/rector.php";
            if (isset($expected['use_rector']) && $expected['use_rector'] === true) {
                $this->assertFileExists($rectorFile, "Rector config should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($rectorFile, "Rector config should NOT exist for variation: $variationName");
            }

            // Psalm
            $psalmFile = $this->tempDir . "/psalm.xml";
            if (isset($expected['use_psalm']) && $expected['use_psalm'] === true) {
                $this->assertFileExists($psalmFile, "Psalm config should exist for variation: $variationName");
            } else {
                $this->assertFileDoesNotExist($psalmFile, "Psalm config should NOT exist for variation: $variationName");
            }
        }
        // Ensure all variations are tested
        $this->assertSame(count($variations), $tested, 'All configuration variations should be tested.');
    }

    /**
     * Provide different configuration variations for testing.
     *
     * Each variation is an associative array of prompt answers.
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function configurationVariations(): array
    {
        return [
            'all features enabled' => [
                'author_name' => 'Test User',
                'author_email' => 'test@example.com',
                'author_username' => 'testuser',
                'vendor_name' => 'TestVendor',
                'vendor_namespace' => 'TestVendor',
                'package_name' => 'TestPackage',
                'class_name' => 'TestPackage',
                'description' => 'A test package',
                'license' => 'MIT',
                'include_funding' => true,
                'php_version' => '^8.2',
                'laravel_version' => '^11.0',
                'include_migration' => true,
                'include_config' => true,
                'include_routes' => true,
                'route_type' => 'both',
                'include_translations' => true,
                'include_assets' => true,
                'include_views' => true,
                'include_command' => true,
                'include_facade' => true,
                'include_tests' => true,
                'use_pint' => true,
                'use_phpstan' => true,
                'use_rector' => true,
                'use_psalm' => true,
                'proceed' => true,
                'composer_install' => false,
                'cleanup' => false,
            ],
            'minimal features' => [
                'author_name' => 'Minimal User',
                'author_email' => 'minimal@example.com',
                'author_username' => 'minimaluser',
                'vendor_name' => 'MinimalVendor',
                'vendor_namespace' => 'MinimalVendor',
                'package_name' => 'MinimalPackage',
                'class_name' => 'MinimalPackage',
                'description' => 'A minimal package',
                'license' => 'MIT',
                'include_funding' => false,
                'php_version' => '^8.1',
                'laravel_version' => '^10.0',
                'include_migration' => false,
                'include_config' => false,
                'include_routes' => false,
                'route_type' => 'none',
                'include_translations' => false,
                'include_assets' => false,
                'include_views' => false,
                'include_command' => false,
                'include_facade' => false,
                'include_tests' => false,
                'use_pint' => false,
                'use_phpstan' => false,
                'use_rector' => false,
                'use_psalm' => false,
                'proceed' => true,
                'composer_install' => false,
                'cleanup' => false,
            ],
        ];
    }

    private function createDir(string $dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    private function deleteDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if (!$file instanceof SplFileInfo) {
                continue;
            }

            if ($file->isDir()) {
                rmdir($file->getRealPath());
                continue;
            }

            unlink($file->getRealPath());
        }

        rmdir($dir);
    }
}
