<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;
use Configurator\ConfigUtil;

final class Tools
{
    public const string FOLDER_NAME = 'Tools';

    public const string PATH = __DIR__ . '/../' . self::FOLDER_NAME;

    public const string PHP_STAN_FILE_NAME = 'phpstan.neon';
    public const string PINT_FILE_NAME = 'pint.json';
    public const string PSALM_FILE_NAME = 'psalm.xml';
    public const string RECTOR_FILE_NAME = 'rector.php';

    public const string PHP_STAN_FILE = self::PATH . '/' . self::PHP_STAN_FILE_NAME;
    public const string PINT_FILE = self::PATH . '/' . self::PINT_FILE_NAME;
    public const string PSALM_FILE = self::PATH . '/' . self::PSALM_FILE_NAME;
    public const string RECTOR_FILE = self::PATH . '/' . self::RECTOR_FILE_NAME;

    public const string PHP_STAN_JOB = "\nphpstan:\n"
        . "  runs-on: ubuntu-latest\n"
        . "  name: PHPStan Analysis\n"
        . "\n"
        . "  steps:\n"
        . "    - name: Checkout code\n"
        . "      uses: actions/checkout@v4\n"
        . "\n"
        . "    - name: Setup PHP\n"
        . "      uses: shivammathur/setup-php@v2\n"
        . "      with:\n"
        . "        php-version: 8.3\n"
        . "        extensions: dom, curl, libxml, mbstring, zip\n"
        . "        coverage: none\n"
        . "\n"
        . "    - name: Install dependencies\n"
        . "      run: composer update --prefer-stable --prefer-dist --no-interaction\n"
        . "\n"
        . "    - name: Run PHPStan analysis\n"
        . "      run: vendor/bin/phpstan analyse --no-progress\n";

    public const string PSALM_JOB = "\npsalm:\n"
        . "  runs-on: ubuntu-latest\n"
        . "  name: Psalm Analysis\n"
        . "\n"
        . "  steps:\n"
        . "    - name: Checkout code\n"
        . "      uses: actions/checkout@v4\n"
        . "\n"
        . "    - name: Setup PHP\n"
        . "      uses: shivammathur/setup-php@v2\n"
        . "      with:\n"
        . "        php-version: 8.3\n"
        . "        extensions: dom, curl, libxml, mbstring, zip\n"
        . "        coverage: none\n"
        . "\n"
        . "    - name: Install dependencies\n"
        . "      run: composer update --prefer-stable --prefer-dist --no-interaction\n"
        . "\n"
        . "    - name: Run Psalm analysis\n"
        . "      run: vendor/bin/psalm --output-format=github\n";

    public const string PINT_JOB = "\ncode-style:\n"
        . "  runs-on: ubuntu-latest\n"
        . "  name: Code Style\n"
        . "\n"
        . "  steps:\n"
        . "    - name: Checkout code\n"
        . "      uses: actions/checkout@v4\n"
        . "\n"
        . "    - name: Setup PHP\n"
        . "      uses: shivammathur/setup-php@v2\n"
        . "      with:\n"
        . "        php-version: 8.3\n"
        . "        extensions: dom, curl, libxml, mbstring, zip\n"
        . "        coverage: none\n"
        . "\n"
        . "    - name: Install dependencies\n"
        . "      run: composer update --prefer-stable --prefer-dist --no-interaction\n"
        . "\n"
        . "    - name: Check code style\n"
        . "      run: vendor/bin/pint --test\n";

    /**
     * Whether to enable Pint by default.
     */
    public const bool IS_PINT_ENABLED = true;

    /**
     * Whether to include PHPStan by default.
     */
    public const bool IS_PHP_STAN_INCLUDED = true;

    /**
     * Whether to include Psalm by default.
     */
    public const bool IS_PSALM_INCLUDED = true;

    /**
     * Whether to include Rector by default.
     */
    public const bool IS_RECTOR_INCLUDED = false;

    /**
     * Setup PHPStan configuration.
     * @param bool $usePhpStan Whether to use PHPStan
     */
    public static function setupPhpStan(bool $usePhpStan): void
    {
        if ($usePhpStan && file_exists(self::PHP_STAN_FILE)) {
            copy(self::PHP_STAN_FILE, ConfiguratorGlobals::getBasePath() . '/' . self::PHP_STAN_FILE_NAME);
        } else {
            ConfigUtil::safeUnlink(ConfiguratorGlobals::getBasePath() . '/' . self::PHP_STAN_FILE_NAME);
            Composer::removeComposerDeps([
                'larastan/larastan',
                'phpstan/extension-installer',
                'phpstan/phpstan-deprecation-rules',
                'phpstan/phpstan-phpunit',
            ]);
            Composer::removeComposerScript('analyse');
        }
    }

    /**
     * Setup Pint configuration.
     * @param bool $usePint Whether to use Pint
     */
    public static function setupPint(bool $usePint): void
    {
        if ($usePint && file_exists(self::PINT_FILE)) {
            copy(self::PINT_FILE, ConfiguratorGlobals::getBasePath() . '/' . self::PINT_FILE_NAME);
        } else {
            ConfigUtil::safeUnlink(ConfiguratorGlobals::getBasePath() . '/' . self::PINT_FILE_NAME);
            Composer::removeComposerDeps([
                'laravel/pint',
            ]);
            Composer::removeComposerScript('code-style');
        }
    }

    /**
     * Setup Rector configuration.
     * @param bool $useRector Whether to use Rector
     */
    public static function setupRector(bool $useRector): void
    {
        if ($useRector && file_exists(self::RECTOR_FILE)) {
            copy(self::RECTOR_FILE, ConfiguratorGlobals::getBasePath() . '/' . self::RECTOR_FILE_NAME);
        } else {
            ConfigUtil::safeUnlink(ConfiguratorGlobals::getBasePath() . '/' . self::RECTOR_FILE_NAME);
            Composer::removeComposerDeps([
                'rector/rector',
            ]);
            Composer::removeComposerScript('rector');
        }
    }

    /**
     * Setup Psalm configuration (with psalm-plugin-laravel).
     * @param bool $usePsalm Whether to use Psalm
     */
    public static function setupPsalm(bool $usePsalm): void
    {
        if ($usePsalm && file_exists(self::PSALM_FILE)) {
            copy(self::PSALM_FILE, ConfiguratorGlobals::getBasePath() . '/' . self::PSALM_FILE_NAME);
        } else {
            ConfigUtil::safeUnlink(ConfiguratorGlobals::getBasePath() . '/' . self::PSALM_FILE_NAME);
            Composer::removeComposerDeps([
                'psalm/plugin-laravel',
            ]);
            Composer::removeComposerScript('psalm');
        }
    }
}
