<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Src
{
    public const string FOLDER = 'src';
    public const string COMMANDS_FOLDER = 'Commands';
    public const string FACADE_FOLDER = 'Facades';

    public const string COMMAND_FILE_NAME = 'CommandSkeleton.php';
    public const string FACADE_FILE_NAME = 'FacadeSkeleton.php';
    public const string SERVICE_PROVIDER_FILE_NAME = 'ServiceProviderSkeleton.php';

    public const string COMMAND_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::COMMANDS_FOLDER
        . '/' . self::COMMAND_FILE_NAME . '.stub';

    public const string FACADE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::FACADE_FOLDER
        . '/' . self::FACADE_FILE_NAME . '.stub';

    public const string SERVICE_PROVIDER_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::SERVICE_PROVIDER_FILE_NAME . '.stub';

    /**
     * Whether to include command by default.
     */
    public const bool IS_COMMAND_INCLUDED = false;

    /**
     * Whether to include facade by default.
     */
    public const bool IS_FACADE_INCLUDED = false;

    /**
     * Get the full path to the src folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the commands folder using the global base path.
     */
    public static function getCommandsPath(): string
    {
        return self::getPath() . '/' . self::COMMANDS_FOLDER;
    }

    /**
     * Get the full path to the facades folder using the global base path.
     */
    public static function getFacadesPath(): string
    {
        return self::getPath() . '/' . self::FACADE_FOLDER;
    }
}
