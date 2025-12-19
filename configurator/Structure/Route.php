<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Route
{
    public const string FOLDER = 'routes';
    public const string WEB_FILE_NAME = 'web.php';
    public const string API_FILE_NAME = 'api.php';

    /**
     * Whether to include routes by default.
     */
    public const bool IS_ROUTES_INCLUDED = false;

    /**
     * Create a sample web.php file.
     */
    public static function createWebFile(): void
    {
        file_put_contents(self::getWebFilePath(), "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n// Define your web routes here\n");
    }

    /**
     * Create a sample api.php file.
     */
    public static function createApiFile(): void
    {
        file_put_contents(self::getApiFilePath(), "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n// Define your API routes here\n");
    }

    /**
     * Get the full path to the routes folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the web.php file using the global base path.
     */
    public static function getWebFilePath(): string
    {
        return self::getPath() . '/' . self::WEB_FILE_NAME;
    }

    /**
     * Get the full path to the api.php file using the global base path.
     */
    public static function getApiFilePath(): string
    {
        return self::getPath() . '/' . self::API_FILE_NAME;
    }
}
