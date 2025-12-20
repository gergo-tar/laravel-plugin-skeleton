<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class PackageJson
{
    public const string FILE_NAME = 'package.json';
    public const string COMMIT_LINT_CONFIG = 'commitlint.config.js';

    public const string STUB = Stub::PATH . '/' . self::FILE_NAME . '.stub';

    public const string STUB_COMMIT_LINT_CONFIG = Stub::PATH . '/' . self::COMMIT_LINT_CONFIG . '.stub';

    /**
     * Whether to include commitlint configuration by default.
     */
    public const bool IS_COMMITLINT_INCLUDED = true;

    /**
     * Get the full path to composer.json using the global base path.
     */
    public static function getFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FILE_NAME;
    }

    /**
     * Get the full path to commitlint.config.js using the global base path.
     */
    public static function getCommitLintFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::COMMIT_LINT_CONFIG;
    }
}
