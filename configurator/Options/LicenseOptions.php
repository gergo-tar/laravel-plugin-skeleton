<?php

namespace Configurator\Options;

final class LicenseOptions
{
    public const string APACHE_2_0 = 'Apache-2.0';
    public const string BSD_2_CLAUSE = 'BSD-2-Clause';
    public const string BSD_3_CLAUSE = 'BSD-3-Clause';
    public const string GPL_3_0 = 'GPL-3.0';
    public const string LGPL_3_0 = 'LGPL-3.0';
    public const string MIT = 'MIT';
    public const string UNLICENSED = 'Unlicensed';

    public const int DEFAULT = 1;

    /**
     * @var array<int, string>
     */
    public const array OPTIONS = [
        1 => self::MIT,
        2 => self::GPL_3_0,
        3 => self::APACHE_2_0,
        4 => self::BSD_3_CLAUSE,
        5 => self::BSD_2_CLAUSE,
        6 => self::LGPL_3_0,
        7 => self::UNLICENSED,
    ];
}
