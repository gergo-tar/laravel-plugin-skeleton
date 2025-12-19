<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class GitHub
{
    public const string FOLDER = '.github';
    public const string WORKFLOWS_FOLDER = 'workflows';

    public const string FUNDING_FILE_NAME = 'FUNDING.yml';
    public const string WORKFLOW_FILE_NAME = 'tests.yml';

    public const string FUNDING_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::FUNDING_FILE_NAME . '.stub';

    public const string WORKFLOW_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::WORKFLOWS_FOLDER
        . '/' . self::WORKFLOW_FILE_NAME . '.stub';

    /**
     * Whether to include workflows by default.
     */
    public const bool IS_WORKFLOW_INCLUDED = true;

    /**
     * Whether to include funding file by default.
     */
    public const bool IS_FUNDING_INCLUDED = false;

    /**
     * Get the full path to the .github folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the workflows folder using the global base path.
     */
    public static function getWorkflowsPath(): string
    {
        return self::getPath() . '/' . self::WORKFLOWS_FOLDER;
    }

    /**
     * Get the full path to the workflow file using the global base path.
     */
    public static function getWorkflowFilePath(): string
    {
        return self::getWorkflowsPath() . '/' . self::WORKFLOW_FILE_NAME;
    }
}
