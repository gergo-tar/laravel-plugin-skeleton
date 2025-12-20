<?php

declare(strict_types=1);

namespace Configurator;

final class ConfiguratorOutput
{
    /**
     * Print the header section.
     */
    public static function printHeader(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('╔══════════════════════════════════════════════════════════════╗');
        ConfigUtil::writeln('║          Laravel Package Skeleton Configuration              ║');
        ConfigUtil::writeln('╚══════════════════════════════════════════════════════════════╝');
        ConfigUtil::writeln('');
    }

    /**
     * Print the author information section.
     */
    public static function printAuthorInformation(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('📝 Author Information');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
    }

    /**
     * Print the package information section.
     */
    public static function printPackageInformation(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('📦 Package Information');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
    }

    /**
     * Print the version requirements section.
     */
    public static function printVersionRequirements(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('⚙️  Version Requirements');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
    }

    /**
     * Print the feature selection section.
     */
    public static function printFeatureSelections(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('✨ Feature Selections');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
        ConfigUtil::writeln('');
        ConfigUtil::writeln('Select features to include:');
        ConfigUtil::writeln('');
    }

    /**
     * Print the development tool selection section.
     */
    public static function printDevToolSelections(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('🛠️  Development Tool Selections');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
    }

    /**
     * Print the configuration summary.
     * @param PackageConfigurator $config The package configuration
     */
    public static function printSummary(PackageConfigurator $config): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('📋 Configuration Summary');
        ConfigUtil::writeln('────────────────────────────────────────────────────────────────');
        ConfigUtil::writeln("Author       : {$config->authorName} ({$config->authorUsername}, {$config->authorEmail})");
        ConfigUtil::writeln("Vendor       : {$config->vendorName} ({$config->vendorSlug})");
        ConfigUtil::writeln("Package      : {$config->packageSlug} <{$config->description}>");
        ConfigUtil::writeln("Namespace    : {$config->vendorNamespace}\\{$config->className}");
        ConfigUtil::writeln("Class name   : {$config->className}");
        ConfigUtil::writeln("License      : {$config->license}");
        ConfigUtil::writeln("PHP Version  : {$config->phpVersion}");
        ConfigUtil::writeln("Laravel      : {$config->laravelVersion}");
        ConfigUtil::writeln('');
        ConfigUtil::writeln('Features:');
        ConfigUtil::writeln("  Migrations     : " . ($config->includeMigration ? 'yes' : 'no'));
        ConfigUtil::writeln("  Config         : " . ($config->includeConfig ? 'yes' : 'no'));
        ConfigUtil::writeln("  Views          : " . ($config->includeViews ? 'yes' : 'no'));
        ConfigUtil::writeln("  Routes         : " . ($config->includeRoutes ? $config->routeType : 'no'));
        ConfigUtil::writeln("  Translations   : " . ($config->includeTranslations ? 'yes' : 'no'));
        ConfigUtil::writeln("  Assets         : " . ($config->includeAssets ? 'yes' : 'no'));
        ConfigUtil::writeln("  Commands       : " . ($config->includeCommand ? 'yes' : 'no'));
        ConfigUtil::writeln("  Facade         : " . ($config->includeFacade ? 'yes' : 'no'));
        ConfigUtil::writeln('');
        ConfigUtil::writeln('Dev Tools:');
        ConfigUtil::writeln("  Commitlint     : " . ($config->useCommitLint ? 'yes' : 'no'));
        ConfigUtil::writeln("  Tests          : " . ($config->includeTests ? 'yes' : 'no'));
        ConfigUtil::writeln("  Pint           : " . ($config->usePint ? 'yes' : 'no'));
        ConfigUtil::writeln("  PHPStan        : " . ($config->usePhpStan ? 'yes' : 'no'));
        ConfigUtil::writeln("  Rector         : " . ($config->useRector ? 'yes' : 'no'));
        ConfigUtil::writeln("  Psalm          : " . ($config->usePsalm ? 'yes' : 'no'));
        ConfigUtil::writeln('══════════════════════════════════════════════════════════════');
        ConfigUtil::writeln('');
    }

    /**
     * Print the finalizing message.
     */
    public static function printFinalizingMessage(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('🔧 Finalizing Package Setup');
        ConfigUtil::writeln('');
    }

    /**
     * Print the completion message.
     */
    public static function printCompletionMessage(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('✅ Package structure generated successfully!');
        ConfigUtil::writeln('');
    }

    /**
     * Print the message before running composer install.
     */
    public static function printRunningComposerMessage(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('🚀 Running composer install...');
        ConfigUtil::writeln('');
    }

    /**
     * Print the completion instructions.
     * @param PackageConfigurator $config The package configuration
     */
    public static function printCompletionInstructions(PackageConfigurator $config): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('🎉 Your package is ready!');
        ConfigUtil::writeln('');
        ConfigUtil::writeln('Next steps:');
        ConfigUtil::writeln('  1. Review the generated files');
        ConfigUtil::writeln('  2. Start coding in src/');

        $index = 3;
        if ($config->includeTests) {
            ConfigUtil::writeln("  {$index}. Write your tests in tests/");
            $index++;
            ConfigUtil::writeln("  {$index}. Run: composer test");
            $index++;
        }

        if ($config->usePint) {
            ConfigUtil::writeln("  {$index}. Run: composer format");
        }

        if ($config->usePhpStan) {
            ConfigUtil::writeln("  {$index}. Run: composer analyse");
        }

        ConfigUtil::writeln('');
    }

    /**
     * Print the cleanup message.
     */
    public static function printCleanupMessage(): void
    {
        ConfigUtil::writeln('');
        ConfigUtil::writeln('🧹 Cleanup completed. Configuration files have been removed.');
        ConfigUtil::writeln('');
    }
}
