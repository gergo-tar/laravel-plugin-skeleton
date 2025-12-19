<?php

namespace Configurator\Options;

final class PhpVersionOptions
{
    public const string PHP_83 = '8.3';
    public const string PHP_84 = '8.4';
    public const string PHP_85 = '8.5';

    public const int DEFAULT = 6;

    /**
     * @var array<int, string>
     */
    public const array OPTIONS = [
        1 => '^' . self::PHP_83,
        2 => '^' . self::PHP_84,
        3 => '^' . self::PHP_85,
        4 => '^' . self::PHP_83 . '|^' . self::PHP_84,
        5 => '^' . self::PHP_84 . '|^' . self::PHP_85,
        6 => '^' . self::PHP_83 . '|^' . self::PHP_84 . '|^' . self::PHP_85,
    ];
}
