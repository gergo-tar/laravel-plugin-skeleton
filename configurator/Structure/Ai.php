<?php

declare(strict_types=1);

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Ai
{
    public const string FOLDER = '.opencode';
    public const string AGENTS_FOLDER = 'agents';
    public const string SKILLS_FOLDER = 'skills';

    public const string AGENTS_FILE_NAME = 'AGENTS.md';
    public const string CLAUDE_FILE_NAME = 'CLAUDE.md';

    public const string COPILOT_FOLDER = '.github';
    public const string COPILOT_FILE_NAME = 'copilot-instructions.md';

    public const string AGENT_ARCHITECT_FILE_NAME = 'architect.md';
    public const string AGENT_PACKAGE_DEVELOPER_FILE_NAME = 'package-developer.md';
    public const string AGENT_TESTING_FILE_NAME = 'testing.md';
    public const string AGENT_DATABASE_FILE_NAME = 'database.md';
    public const string AGENT_API_FILE_NAME = 'api.md';
    public const string AGENT_SECURITY_FILE_NAME = 'security.md';
    public const string AGENT_PERFORMANCE_FILE_NAME = 'performance.md';
    public const string AGENT_REVIEWER_FILE_NAME = 'reviewer.md';

    public const string SKILL_PACKAGE_DEVELOPMENT = 'package-development';
    public const string SKILL_LARAVEL_PACKAGE = 'laravel-package';
    public const string SKILL_TESTING = 'testing';
    public const string SKILL_API = 'api';
    public const string SKILL_DATABASE = 'database';
    public const string SKILL_CODE_REVIEW = 'code-review';
    public const string SKILL_RELEASE = 'release';

    public const string STUB_FOLDER = 'ai';
    public const string SKILL_FILE_NAME = 'SKILL.md';

    public const string AGENTS_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FILE_NAME . '.stub';

    public const string CLAUDE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::CLAUDE_FILE_NAME . '.stub';

    public const string COPILOT_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::COPILOT_FILE_NAME . '.stub';

    public const string AGENT_ARCHITECT_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_ARCHITECT_FILE_NAME . '.stub';

    public const string AGENT_PACKAGE_DEVELOPER_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_PACKAGE_DEVELOPER_FILE_NAME . '.stub';

    public const string AGENT_TESTING_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_TESTING_FILE_NAME . '.stub';

    public const string AGENT_DATABASE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_DATABASE_FILE_NAME . '.stub';

    public const string AGENT_API_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_API_FILE_NAME . '.stub';

    public const string AGENT_SECURITY_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_SECURITY_FILE_NAME . '.stub';

    public const string AGENT_PERFORMANCE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_PERFORMANCE_FILE_NAME . '.stub';

    public const string AGENT_REVIEWER_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::AGENTS_FOLDER
        . '/' . self::AGENT_REVIEWER_FILE_NAME . '.stub';

    public const string SKILL_PACKAGE_DEVELOPMENT_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_PACKAGE_DEVELOPMENT
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_LARAVEL_PACKAGE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_LARAVEL_PACKAGE
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_TESTING_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_TESTING
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_API_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_API
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_DATABASE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_DATABASE
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_CODE_REVIEW_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_CODE_REVIEW
        . '/' . self::SKILL_FILE_NAME . '.stub';

    public const string SKILL_RELEASE_STUB = Stub::PATH
        . '/' . self::STUB_FOLDER
        . '/' . self::SKILLS_FOLDER
        . '/' . self::SKILL_RELEASE
        . '/' . self::SKILL_FILE_NAME . '.stub';

    /**
     * Whether AI-agent support is enabled by default.
     */
    public const bool IS_SUPPORT_ENABLED = true;

    /**
     * Whether the canonical AGENTS.md project instructions are generated by default.
     */
    public const bool IS_AGENTS_MD_INCLUDED = true;

    /**
     * Whether OpenCode agent templates are generated by default.
     */
    public const bool IS_OPENCODE_AGENTS_INCLUDED = true;

    /**
     * Whether OpenCode skills are generated by default.
     */
    public const bool IS_OPENCODE_SKILLS_INCLUDED = true;

    /**
     * Whether Claude Code compatibility (CLAUDE.md) is included by default.
     */
    public const bool IS_CLAUDE_COMPAT_INCLUDED = false;

    /**
     * Whether GitHub Copilot instructions are included by default.
     */
    public const bool IS_COPILOT_INSTRUCTIONS_INCLUDED = false;

    /**
     * Get the full path to the .opencode folder using the global base path.
     */
    public static function getPath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FOLDER;
    }

    /**
     * Get the full path to the .opencode/agents folder using the global base path.
     */
    public static function getAgentsPath(): string
    {
        return self::getPath() . '/' . self::AGENTS_FOLDER;
    }

    /**
     * Get the full path to the .opencode/skills folder using the global base path.
     */
    public static function getSkillsPath(): string
    {
        return self::getPath() . '/' . self::SKILLS_FOLDER;
    }

    /**
     * Get the full path to the root AGENTS.md file using the global base path.
     */
    public static function getAgentsFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::AGENTS_FILE_NAME;
    }

    /**
     * Get the full path to the CLAUDE.md file using the global base path.
     */
    public static function getClaudeFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::CLAUDE_FILE_NAME;
    }

    /**
     * Get the full path to the GitHub Copilot instructions file using the global base path.
     */
    public static function getCopilotFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/')
            . '/' . self::COPILOT_FOLDER
            . '/' . self::COPILOT_FILE_NAME;
    }
}
