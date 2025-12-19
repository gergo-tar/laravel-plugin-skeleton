<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Test
{
    public const string FOLDER = 'tests';
    public const string FEATURE_TESTS_FOLDER = 'Feature';
    public const string UNIT_TESTS_FOLDER = 'Unit';

    public const string FEATURE_TEST_FILE_NAME = 'ExampleTest.php';
    public const string PEST_FILE_NAME = 'Pest.php';
    public const string PHP_UNIT_FILE_NAME = 'phpunit.xml';
    public const string TESTCASE_FILE_NAME = 'TestCase.php';
    public const string UNIT_TEST_FILE_NAME = 'ExampleTest.php';

    public const string FEATURE_TEST_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::FEATURE_TESTS_FOLDER
        . '/' . self::FEATURE_TEST_FILE_NAME . '.stub';

    public const string PEST_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::PEST_FILE_NAME . '.stub';

    public const string PHPUNIT_STUB = Stub::PATH . '/' . self::PHP_UNIT_FILE_NAME . '.stub';

    public const string TESTCASE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::TESTCASE_FILE_NAME . '.stub';

    public const string UNIT_TEST_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::UNIT_TESTS_FOLDER
        . '/' . self::UNIT_TEST_FILE_NAME . '.stub';

    /**
     * Whether to include tests by default.
     */
    public const bool IS_TESTS_INCLUDED = false;

    /**
     * Get the full path to the test folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the feature tests folder using the global base path.
     */
    public static function getFeatureTestsPath(): string
    {
        return self::getPath() . '/' . self::FEATURE_TESTS_FOLDER;
    }

    /**
     * Get the full path to the unit tests folder using the global base path.
     */
    public static function getUnitTestsPath(): string
    {
        return self::getPath() . '/' . self::UNIT_TESTS_FOLDER;
    }
}
