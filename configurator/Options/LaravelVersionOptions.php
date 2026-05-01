<?php

namespace Configurator\Options;

final class LaravelVersionOptions
{
    public const string LARAVEL_11 = '11';
    public const string LARAVEL_12 = '12';
    public const string LARAVEL_13 = '13';

    public const int DEFAULT = 3;

    /**
     * @var array<int, string>
     */
    public const array OPTIONS = [
        1 => '^' . self::LARAVEL_11,
        2 => '^' . self::LARAVEL_12,
        3 => '^' . self::LARAVEL_13,
    ];
}
