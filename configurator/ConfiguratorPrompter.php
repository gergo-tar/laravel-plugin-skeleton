<?php

declare(strict_types=1);

namespace Configurator;

use Configurator\ConfigUtil;
use Configurator\Structure\Src;
use Configurator\Structure\Test;
use Configurator\Structure\Route;
use Configurator\Structure\Tools;
use Configurator\Structure\Config;
use Configurator\Structure\GitHub;
use Configurator\Structure\Composer;
use Configurator\Structure\Database;
use Configurator\Structure\Resource;
use Configurator\Structure\PackageJson;
use Configurator\Options\LicenseOptions;
use Configurator\Options\RouteTypeOptions;
use Configurator\Options\PhpVersionOptions;
use Configurator\Options\LaravelVersionOptions;

final class ConfiguratorPrompter implements PrompterInterface
{
    /**
     * Prompt for the author's name.
     * @return string The author's name
     */
    #[\Override]
    public function promptAuthorName(): string
    {
        $gitName = ConfigUtil::run('git config user.name');
        return ConfigUtil::ask('Author name', $gitName);
    }

    /**
     * Prompt for the author's email.
     * @return string The author's email
     */
    #[\Override]
    public function promptAuthorEmail(): string
    {
        $gitEmail = ConfigUtil::run('git config user.email');
        return ConfigUtil::ask('Author email', $gitEmail);
    }

    /**
     * Prompt for the author's username (e.g., GitHub username).
     * @return string The author's username
     */
    #[\Override]
    public function promptAuthorUsername(): string
    {
        $remote = ConfigUtil::run('git config remote.origin.url');
        $usernameGuess = '';

        if ($remote) {
            $parts = explode(':', $remote);
            if (isset($parts[1])) {
                $usernameGuess = basename(dirname($parts[1]));
            }
        }

        return ConfigUtil::ask('Author username (GitHub)', $usernameGuess);
    }

    /**
     * Prompt for the class name.
     * @param string|null $defaultClassName The default class name
     * @return string The class name
     */
    #[\Override]
    public function promptClassName(?string $defaultClassName = null): string
    {
        return ConfigUtil::ask('Class name', $defaultClassName ?? 'MyPackage');
    }

    /**
     * Prompt whether to clean up the script after execution.
     * @return bool True to clean up, false otherwise
     */
    #[\Override]
    public function promptCleanup(): bool
    {
        return ConfigUtil::confirm('Let this script delete itself?', true);
    }

    /**
     * Prompt whether to execute `composer install`.
     * @return bool True to execute, false otherwise
     */
    #[\Override]
    public function promptComposerInstall(): bool
    {
        return ConfigUtil::confirm('Execute `composer install`?', Composer::IS_COMPOSER_INSTALL_ENABLED);
    }

    /**
     * Prompt for the package description.
     * @param string|null $defaultDescription The default package description
     * @return string The package description
     */
    #[\Override]
    public function promptDescription(?string $defaultDescription = null): string
    {
        return ConfigUtil::ask('Package description', $defaultDescription ?? 'A Laravel package');
    }

    /**
     * Prompt for using commitlint and semantic versioning.
     * @return bool
     */
    #[\Override]
    public function promptEnableCommitLint(): bool
    {
        return ConfigUtil::confirm('Use commitlint, commitizen and semantic versioning?', PackageJson::IS_COMMITLINT_INCLUDED);
    }

    /**
     * Prompt whether to enable PHPStan.
     * @return bool True to enable PHPStan, false otherwise
     */
    #[\Override]
    public function promptEnablePint(): bool
    {
        return  ConfigUtil::confirm('Enable Pint (code style)?', Tools::IS_PINT_ENABLED);
    }

    /**
     * Prompt whether to enable PHPStan.
     * @return bool True to enable PHPStan, false otherwise
     */
    #[\Override]
    public function promptEnablePhpStan(): bool
    {
        return ConfigUtil::confirm('Enable PHPStan (Larastan)?', Tools::IS_PHP_STAN_INCLUDED);
    }

    /**
     * Prompt whether to enable Psalm.
     * @return bool True to enable, false otherwise
     */
    #[\Override]
    public function promptEnablePsalm(): bool
    {
        return ConfigUtil::confirm('Enable Psalm (with psalm-plugin-laravel)?', true);
    }

    /**
     * Prompt whether to enable Rector.
     * @return bool True to enable Rector, false otherwise
     */
    #[\Override]
    public function promptEnableRector(): bool
    {
        return ConfigUtil::confirm('Enable Rector?', Tools::IS_RECTOR_INCLUDED);
    }

    /**
     * Prompt whether to include assets (CSS/JS).
     * @return bool True to include assets, false otherwise
     */
    #[\Override]
    public function promptIncludeAssets(): bool
    {
        return ConfigUtil::confirm('Include assets (CSS/JS)?', Resource::IS_ASSETS_INCLUDED);
    }

    /**
     * Prompt whether to include an Artisan command.
     * @return bool True to include command, false otherwise
     */
    #[\Override]
    public function promptIncludeCommand(): bool
    {
        return ConfigUtil::confirm('Include Artisan command?', Src::IS_COMMAND_INCLUDED);
    }

    /**
     * Prompt whether to include configuration file.
     * @return bool True to include config, false otherwise
     */
    #[\Override]
    public function promptIncludeConfig(): bool
    {
        return ConfigUtil::confirm('Include configuration file?', Config::IS_CONFIG_INCLUDED);
    }

    /**
     * Prompt whether to include a Facade.
     * @return bool True to include facade, false otherwise
     */
    #[\Override]
    public function promptIncludeFacade(): bool
    {
        return ConfigUtil::confirm('Include Facade?', Src::IS_FACADE_INCLUDED);
    }

    /**
     * Prompt whether to include funding information.
     * @return bool True to include funding, false otherwise
     */
    #[\Override]
    public function promptIncludeFunding(): bool
    {
        return ConfigUtil::confirm('Include funding information?', GitHub::IS_FUNDING_INCLUDED);
    }

    /**
     * Prompt whether to include migrations.
     * @return bool True to include migrations, false otherwise
     */
    #[\Override]
    public function promptIncludeMigration(): bool
    {
        return ConfigUtil::confirm('Include migration file?', Database::IS_MIGRATION_INCLUDED);
    }

    /**
     * Prompt whether to include routes.
     * @return bool True to include routes, false otherwise
     */
    #[\Override]
    public function promptIncludeRoutes(): bool
    {
        return ConfigUtil::confirm('Include routes?', Route::IS_ROUTES_INCLUDED);
    }

    /**
     * Prompt whether to include test files.
     * @return bool True to include tests, false otherwise
     */
    #[\Override]
    public function promptIncludeTests(): bool
    {
        return ConfigUtil::confirm('Include test files?', Test::IS_TESTS_INCLUDED);
    }

    /**
     * Prompt whether to include translations.
     * @return bool True to include translations, false otherwise
     */
    #[\Override]
    public function promptIncludeTranslations(): bool
    {
        return ConfigUtil::confirm('Include translations?', Resource::IS_TRANSLATIONS_INCLUDED);
    }

    /**
     * Prompt whether to include resources (views, assets, etc.).
     * @return bool True to include resources, false otherwise
     */
    #[\Override]
    public function promptIncludeViews(): bool
    {
        return ConfigUtil::confirm('Include views?', Resource::IS_VIEWS_INCLUDED);
    }

    /**
     * Prompt for the Laravel version support.
     * @return string The Laravel version
     */
    #[\Override]
    public function promptLaravelVersion(): string
    {
        return ConfigUtil::choice(
            'Laravel version support',
            LaravelVersionOptions::OPTIONS,
            LaravelVersionOptions::DEFAULT
        );
    }

    /**
     * Prompt for the license type.
     * @return string The license type
     */
    #[\Override]
    public function promptLicense(): string
    {
        return ConfigUtil::choice(
            'Select license',
            LicenseOptions::OPTIONS,
            LicenseOptions::DEFAULT
        );
    }

    /**
     * Prompt for the package name.
     * @param string|null $defaultName The default package name
     * @return string The package name
     */
    #[\Override]
    public function promptPackageName(?string $defaultName = null): string
    {
        return ConfigUtil::ask('Package name', $defaultName ?? 'MyPackage');
    }

    /**
     * Prompt for the PHP version requirement.
     * @return string The PHP version
     */
    #[\Override]
    public function promptPhpVersion(): string
    {
        return ConfigUtil::choice(
            'PHP version requirement',
            PhpVersionOptions::OPTIONS,
            PhpVersionOptions::DEFAULT
        );
    }

    /**
     * Prompt whether to proceed with the configuration.
     * @return bool True to proceed, false otherwise
     */
    #[\Override]
    public function promptProceed(): bool
    {
        return ConfigUtil::confirm('Proceed with the above configuration?', true);
    }

    /**
     * Prompt for the route type.
     * @return string The route type
     */
    #[\Override]
    public function promptRouteType(): string
    {
        return ConfigUtil::choice('Route type', RouteTypeOptions::OPTIONS, RouteTypeOptions::DEFAULT);
    }

    /**
     * Prompt for the vendor name.
     * @param string|null $defaultName The default vendor name
     * @return string The vendor name
     */
    #[\Override]
    public function promptVendorName(?string $defaultName = null): string
    {
        return ConfigUtil::ask(
            'Vendor name (e.g., your GitHub username or organization)',
            $defaultName ?? 'MyVendor'
        );
    }

    /**
     * Prompt for the vendor namespace.
     * @param string|null $defaultNamespace The default vendor namespace
     * @return string The vendor namespace
     */
    #[\Override]
    public function promptVendorNamespace(?string $defaultNamespace = null): string
    {
        return ConfigUtil::ask(
            'Vendor namespace (e.g., YourGitHubUsernameOrOrganization)',
            $defaultNamespace ?? 'MyVendor'
        );
    }
}
