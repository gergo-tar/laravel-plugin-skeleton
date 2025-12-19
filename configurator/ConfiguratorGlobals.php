<?php

declare(strict_types=1);

namespace Configurator;

final class ConfiguratorGlobals
{
    private static string $basePath = '';

    public static function setBasePath(string $path): void
    {
        self::$basePath = $path;
    }

    public static function getBasePath(): string
    {
        return self::$basePath !== '' ? self::$basePath : (string) getcwd();
    }
}
