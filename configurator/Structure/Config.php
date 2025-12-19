<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Config
{
    public const string FOLDER = 'config';
    public const string FILE_NAME = 'config_skeleton.php';
    public const string STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::FILE_NAME . '.stub';

    /**
     * Whether to include config by default.
     */
    public const bool IS_CONFIG_INCLUDED = true;

    /**
     * Get the full path to the config folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }
}
