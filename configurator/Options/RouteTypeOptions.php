<?php

namespace Configurator\Options;

final class RouteTypeOptions
{
    public const string API = 'api.php';
    public const string WEB = 'web.php';
    public const string BOTH = 'both';

    public const int DEFAULT = 1;

    /**
     * @var array<int, string>
     */
    public const array OPTIONS = [
        1 => self::WEB,
        2 => self::API,
        3 => self::BOTH,
    ];
}
