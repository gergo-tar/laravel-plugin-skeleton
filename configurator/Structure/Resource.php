<?php

namespace Configurator\Structure;

use Configurator\ConfigUtil;
use Configurator\ConfiguratorGlobals;

final class Resource
{
    public const string FOLDER = 'resources';
    public const string CSS_FOLDER = 'css';
    public const string JS_FOLDER = 'js';
    public const string LANG_FOLDER = 'lang';
    public const string VIEWS_FOLDER = 'views';

    public const string CSS_FILE_NAME = 'app.css';
    public const string JS_FILE_NAME = 'app.js';

    /**
     * Whether to include css and JS assets by default.
     */
    public const bool IS_ASSETS_INCLUDED = false;

    /**
     * Whether to include translation files by default.
     */
    public const bool IS_TRANSLATIONS_INCLUDED = false;

    /**
     * Whether to include views by default.
     */
    public const bool IS_VIEWS_INCLUDED = false;

    /**
     * Create a sample CSS file.
     */
    public static function createCssFile(): void
    {
        ConfigUtil::createDirectoryIfNotExists(Resource::getCssPath());
        file_put_contents(self::getCssPath() . '/' . self::CSS_FILE_NAME, "/* Package styles */\n");
    }

    /**
     * Create a sample JS file.
     */
    public static function createJsFile(): void
    {
        ConfigUtil::createDirectoryIfNotExists(Resource::getJsPath());
        file_put_contents(self::getJsPath() . '/' . self::JS_FILE_NAME, "// Package scripts\n");
    }

    /**
     * Create a sample lang file.
     */
    public static function createLangFile(): void
    {
        ConfigUtil::createDirectoryIfNotExists(Resource::getLangPath());
        ConfigUtil::createDirectoryIfNotExists(Resource::getEnLangPath());
        $content = "<?php\n\nreturn [\n    // Add your keys here\n];\n";
        file_put_contents(self::getEnLangPath() . '/messages.php', $content);
    }

    /**
     * Get the full path to the resources folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the CSS folder using the global base path.
     */
    public static function getCssPath(): string
    {
        return self::getPath() . '/' . self::CSS_FOLDER;
    }

    /**
     * Get the full path to the JS folder using the global base path.
     */
    public static function getJsPath(): string
    {
        return self::getPath() . '/' . self::JS_FOLDER;
    }

    /**
     * Get the full path to the lang folder using the global base path.
     */
    public static function getLangPath(): string
    {
        return self::getPath() . '/' . self::LANG_FOLDER;
    }

    /**
     * Get the full path to the en lang folder using the global base path.
     */
    public static function getEnLangPath(): string
    {
        return self::getLangPath() . '/en';
    }

    /**
     * Get the full path to the views folder using the global base path.
     */
    public static function getViewsPath(): string
    {
        return self::getPath() . '/' . self::VIEWS_FOLDER;
    }
}
