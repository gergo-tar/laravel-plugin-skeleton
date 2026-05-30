<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class GitHub
{
    public const string FOLDER = '.github';
    public const string WORKFLOWS_FOLDER = 'workflows';
    public const string ISSUE_TEMPLATE_FOLDER = 'ISSUE_TEMPLATE';

    public const string FUNDING_FILE_NAME = 'FUNDING.yml';
    public const string SECURITY_FILE_NAME = 'SECURITY.md';
    public const string SUPPORT_FILE_NAME = 'SUPPORT.md';
    public const string CODE_OF_CONDUCT_FILE_NAME = 'CODE_OF_CONDUCT.md';
    public const string PULL_REQUEST_TEMPLATE_FILE_NAME = 'pull_request_template.md';
    public const string ISSUE_TEMPLATE_BUG_FILE_NAME = 'bug_report.yml';
    public const string ISSUE_TEMPLATE_FEATURE_FILE_NAME = 'feature_request.yml';
    public const string GIT_CLIFF_FILE_NAME = 'cliff.toml';
    public const string WORKFLOW_FILE_NAME = 'ci.yml';
    public const string WORKFLOW_PACKAGIST_SYNC_FILE_NAME = 'packagist-sync.yml';
    public const string WORKFLOW_RELEASE_PLEASE_FILE_NAME = 'release-please.yml';

    public const string FUNDING_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::FUNDING_FILE_NAME . '.stub';

    public const string SECURITY_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::SECURITY_FILE_NAME . '.stub';

    public const string SUPPORT_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::SUPPORT_FILE_NAME . '.stub';

    public const string CODE_OF_CONDUCT_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::CODE_OF_CONDUCT_FILE_NAME . '.stub';

    public const string PULL_REQUEST_TEMPLATE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::PULL_REQUEST_TEMPLATE_FILE_NAME . '.stub';

    public const string ISSUE_TEMPLATE_BUG_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::ISSUE_TEMPLATE_FOLDER
        . '/' . self::ISSUE_TEMPLATE_BUG_FILE_NAME . '.stub';

    public const string ISSUE_TEMPLATE_FEATURE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::ISSUE_TEMPLATE_FOLDER
        . '/' . self::ISSUE_TEMPLATE_FEATURE_FILE_NAME . '.stub';

    public const string GIT_CLIFF_STUB = Stub::PATH
        . '/' . self::GIT_CLIFF_FILE_NAME . '.stub';

    public const string WORKFLOW_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::WORKFLOWS_FOLDER
        . '/' . self::WORKFLOW_FILE_NAME . '.stub';

    public const string WORKFLOW_PACKAGIST_SYNC_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::WORKFLOWS_FOLDER
        . '/' . self::WORKFLOW_PACKAGIST_SYNC_FILE_NAME . '.stub';

    public const string WORKFLOW_RELEASE_PLEASE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::WORKFLOWS_FOLDER
        . '/' . self::WORKFLOW_RELEASE_PLEASE_FILE_NAME . '.stub';

    /**
     * Whether to include funding file by default.
     */
    public const bool IS_FUNDING_INCLUDED = false;
    public const bool IS_COVERAGE_REPORTING_INCLUDED = false;
    public const bool IS_SECURITY_POLICY_INCLUDED = false;
    public const bool IS_SUPPORT_POLICY_INCLUDED = false;
    public const bool IS_CODE_OF_CONDUCT_INCLUDED = false;
    public const bool IS_ISSUE_TEMPLATES_INCLUDED = false;
    public const bool IS_PULL_REQUEST_TEMPLATE_INCLUDED = false;

    /**
     * Whether to include workflows by default.
     */
    public const bool IS_WORKFLOW_INCLUDED = true;

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
     * Get the full path to the issue templates folder using the global base path.
     */
    public static function getIssueTemplatesPath(): string
    {
        return self::getPath() . '/' . self::ISSUE_TEMPLATE_FOLDER;
    }

    /**
     * Get the full path to the workflow file using the global base path.
     */
    public static function getWorkflowFilePath(): string
    {
        return self::getWorkflowsPath() . '/' . self::WORKFLOW_FILE_NAME;
    }

    /**
     * Get the full path to the packagist sync workflow file using the global base path.
     */
    public static function getWorkflowPackagistSyncFilePath(): string
    {
        return self::getWorkflowsPath() . '/' . self::WORKFLOW_PACKAGIST_SYNC_FILE_NAME;
    }

    /**
     * Get the full path to the release please workflow file using the global base path.
     */
    public static function getWorkflowReleasePleaseFilePath(): string
    {
        return self::getWorkflowsPath() . '/' . self::WORKFLOW_RELEASE_PLEASE_FILE_NAME;
    }

    /**
     * Get the full path to the security policy file using the global base path.
     */
    public static function getSecurityFilePath(): string
    {
        return self::getPath() . '/' . self::SECURITY_FILE_NAME;
    }

    /**
     * Get the full path to the support file using the global base path.
     */
    public static function getSupportFilePath(): string
    {
        return self::getPath() . '/' . self::SUPPORT_FILE_NAME;
    }

    /**
     * Get the full path to the code of conduct file using the global base path.
     */
    public static function getCodeOfConductFilePath(): string
    {
        return self::getPath() . '/' . self::CODE_OF_CONDUCT_FILE_NAME;
    }

    /**
     * Get the full path to the pull request template file using the global base path.
     */
    public static function getPullRequestTemplateFilePath(): string
    {
        return self::getPath() . '/' . self::PULL_REQUEST_TEMPLATE_FILE_NAME;
    }

    /**
     * Get the full path to the bug issue template file using the global base path.
     */
    public static function getIssueTemplateBugFilePath(): string
    {
        return self::getIssueTemplatesPath() . '/' . self::ISSUE_TEMPLATE_BUG_FILE_NAME;
    }

    /**
     * Get the full path to the feature request issue template file using the global base path.
     */
    public static function getIssueTemplateFeatureFilePath(): string
    {
        return self::getIssueTemplatesPath() . '/' . self::ISSUE_TEMPLATE_FEATURE_FILE_NAME;
    }

    /**
     * Get the full path to the Git Cliff configuration file using the global base path.
     */
    public static function getGitCliffFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::GIT_CLIFF_FILE_NAME;
    }
}
