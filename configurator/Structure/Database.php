<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Database
{
    public const string FOLDER = 'database';
    public const string MIGRATIONS_FOLDER = 'migrations';
    public const string MIGRATION_FILE_NAME = 'create_table_skeleton.php';
    public const string MIGRATION_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::MIGRATIONS_FOLDER
        . '/' . self::MIGRATION_FILE_NAME . '.stub';

    /**
     * Whether to include migrations by default.
     */
    public const bool IS_MIGRATION_INCLUDED = true;

    /**
     * Get the full path to the migrations folder using the global base path.
     */
    public static function getMigrationPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER . '/' . self::MIGRATIONS_FOLDER;
    }
}
