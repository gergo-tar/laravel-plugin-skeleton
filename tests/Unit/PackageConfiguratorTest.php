<?php

declare(strict_types=1);

namespace Tests\Unit;

use SplFileInfo;
use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use Tests\TestPrompter;
use Configurator\PackageConfigurator;

function createDir(string $dir): void
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

function deleteDir(string $dir): void
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

/**
 * Provides different configuration variations for testing.
 *
 * @return array<string, array<string, bool|string>>
 */
function configurationVariations(): array
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

test('all configuration variations are tested and files generated as expected', function () {
    $tempDir = __DIR__ . '/../generated-test';
    $variations = configurationVariations();
    $tested = 0;
    foreach ($variations as $expected) {
        $tested++;
        if (is_dir($tempDir)) {
            deleteDir($tempDir);
        }
        createDir($tempDir);

        $prompter = new TestPrompter($expected);
        $configurator = new PackageConfigurator($prompter);
        $configurator->run($tempDir);

        $package = isset($expected['package_name']) && is_string($expected['package_name'])
            ? strtolower($expected['package_name'])
            : 'config';

        $configFile = $tempDir . "/config/{$package}.php";
        if (isset($expected['include_config']) && $expected['include_config'] === true) {
            expect($configFile)->toBeFile();
        } else {
            expect($configFile)->not->toBeFile();
        }

        $migrationFile = $tempDir . "/database/migrations/create_{$package}_table.php";
        if (isset($expected['include_migration']) && $expected['include_migration'] === true) {
            expect($migrationFile)->toBeFile();
        } else {
            expect($migrationFile)->not->toBeFile();
        }

        $webRoute = $tempDir . "/routes/web.php";
        $apiRoute = $tempDir . "/routes/api.php";
        if (isset($expected['include_routes']) && $expected['include_routes'] === true) {
            if (isset($expected['route_type']) && ($expected['route_type'] === 'web' || $expected['route_type'] === 'both')) {
                expect($webRoute)->toBeFile();
            } else {
                expect($webRoute)->not->toBeFile();
            }
            if (isset($expected['route_type']) && ($expected['route_type'] === 'api' || $expected['route_type'] === 'both')) {
                expect($apiRoute)->toBeFile();
            } else {
                expect($apiRoute)->not->toBeFile();
            }
        } else {
            expect($webRoute)->not->toBeFile();
            expect($apiRoute)->not->toBeFile();
        }

        $translationFile = $tempDir . "/resources/lang/en/messages.php";
        if (isset($expected['include_translations']) && $expected['include_translations'] === true) {
            expect($translationFile)->toBeFile();
        } else {
            expect($translationFile)->not->toBeFile();
        }

        $cssDir = $tempDir . "/resources/css";
        $jsDir = $tempDir . "/resources/js";
        if (isset($expected['include_assets']) && $expected['include_assets'] === true) {
            expect($cssDir)->toBeDirectory();
            expect($jsDir)->toBeDirectory();
        } else {
            expect($cssDir)->not->toBeDirectory();
            expect($jsDir)->not->toBeDirectory();
        }

        $viewsDir = $tempDir . "/resources/views";
        if (isset($expected['include_views']) && $expected['include_views'] === true) {
            expect($viewsDir)->toBeDirectory();
        } else {
            expect($viewsDir)->not->toBeDirectory();
        }

        $commandFile = $tempDir . "/src/Commands/{$expected['class_name']}Command.php";
        if (isset($expected['include_command']) && $expected['include_command'] === true) {
            expect($commandFile)->toBeFile();
        } else {
            expect($commandFile)->not->toBeFile();
        }

        $facadeFile = $tempDir . "/src/Facades/{$expected['class_name']}Facade.php";
        if (isset($expected['include_facade']) && $expected['include_facade'] === true) {
            expect($facadeFile)->toBeFile();
        } else {
            expect($facadeFile)->not->toBeFile();
        }

        $featureTest = $tempDir . "/tests/Feature/ExampleTest.php";
        $unitTest = $tempDir . "/tests/Unit/ExampleTest.php";
        if (isset($expected['include_tests']) && $expected['include_tests'] === true) {
            expect($featureTest)->toBeFile();
            expect($unitTest)->toBeFile();
        } else {
            expect($featureTest)->not->toBeFile();
            expect($unitTest)->not->toBeFile();
        }

        $pintFile = $tempDir . "/pint.json";
        if (isset($expected['use_pint']) && $expected['use_pint'] === true) {
            expect($pintFile)->toBeFile();
        } else {
            expect($pintFile)->not->toBeFile();
        }

        $phpstanFile = $tempDir . "/phpstan.neon";
        if (isset($expected['use_phpstan']) && $expected['use_phpstan'] === true) {
            expect($phpstanFile)->toBeFile();
        } else {
            expect($phpstanFile)->not->toBeFile();
        }

        $rectorFile = $tempDir . "/rector.php";
        if (isset($expected['use_rector']) && $expected['use_rector'] === true) {
            expect($rectorFile)->toBeFile();
        } else {
            expect($rectorFile)->not->toBeFile();
        }

        $psalmFile = $tempDir . "/psalm.xml";
        if (isset($expected['use_psalm']) && $expected['use_psalm'] === true) {
            expect($psalmFile)->toBeFile();
        } else {
            expect($psalmFile)->not->toBeFile();
        }
    }
    expect($tested)->toBe(count($variations));
    deleteDir($tempDir);
});
