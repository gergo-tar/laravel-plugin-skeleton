<?php

declare(strict_types=1);

namespace Tests\Unit;

use Configurator\PackageConfigurator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Tests\TestPrompter;

function aiCreateDir(string $dir): void
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

function aiDeleteDir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if (!$file instanceof SplFileInfo) {
            continue;
        }
        if ($file->isDir()) {
            rmdir($file->getRealPath());
            continue;
        }
        unlink($file->getRealPath());
    }
    rmdir($dir);
}

/**
 * Default answers for an AI-enabled generation with every package feature enabled.
 *
 * @return array<string, bool|string>
 */
function aiBaseAnswers(): array
{
    return [
        'author_name' => 'AI Test User',
        'author_email' => 'ai@example.com',
        'author_username' => 'aiuser',
        'vendor_name' => 'AIVendor',
        'vendor_namespace' => 'AIVendor',
        'package_name' => 'AiPackage',
        'class_name' => 'AiPackage',
        'description' => 'An AI-assisted test package',
        'license' => 'MIT',
        'main_branch_name' => 'main',
        'php_version' => '^8.5',
        'laravel_version' => '^13',
        'include_migration' => true,
        'include_config' => true,
        'include_routes' => true,
        'route_type' => 'both',
        'include_translations' => true,
        'include_assets' => true,
        'include_views' => true,
        'include_command' => true,
        'include_facade' => true,
        'include_tests' => true,
        'use_commitlint' => true,
        'use_pint' => true,
        'use_phpstan' => true,
        'use_psalm' => true,
        'use_rector' => true,
        'enable_ai_support' => true,
        'select_all_ai_features' => false,
        'include_agents_md' => true,
        'include_opencode_agents' => true,
        'include_opencode_skills' => true,
        'include_claude_compatibility' => false,
        'include_copilot_instructions' => false,
        'proceed' => true,
        'composer_install' => false,
        'cleanup' => false,
    ];
}

/**
 * @param array<string, bool|string> $overrides
 */
function aiGeneratePackage(array $overrides, string $tempDir): void
{
    aiDeleteDir($tempDir);
    aiCreateDir($tempDir);

    $answers = aiBaseAnswers();
    foreach ($overrides as $key => $value) {
        $answers[$key] = $value;
    }

    $configurator = new PackageConfigurator(new TestPrompter($answers));
    $configurator->run($tempDir);
}

test('AI agent support can be disabled entirely', function () {
    $tempDir = __DIR__ . '/../ai-disabled-test';
    aiGeneratePackage(['enable_ai_support' => false], $tempDir);

    expect($tempDir . '/AGENTS.md')->not->toBeFile();
    expect($tempDir . '/CLAUDE.md')->not->toBeFile();
    expect($tempDir . '/.opencode')->not->toBeDirectory();
    expect($tempDir . '/.github/copilot-instructions.md')->not->toBeFile();

    aiDeleteDir($tempDir);
});

test('default AI setup generates AGENTS.md, agents and skills without placeholders or leftover conditional markers', function () {
    $tempDir = __DIR__ . '/../ai-default-test';
    aiGeneratePackage([], $tempDir);

    $agentsPath = $tempDir . '/.opencode/agents';
    $skillsPath = $tempDir . '/.opencode/skills';

    expect($agentsPath)->toBeDirectory();
    expect($skillsPath)->toBeDirectory();
    expect($tempDir . '/AGENTS.md')->toBeFile();
    expect($tempDir . '/CLAUDE.md')->not->toBeFile();
    expect($tempDir . '/.github/copilot-instructions.md')->not->toBeFile();

    $agentsContent = file_get_contents($tempDir . '/AGENTS.md');
    expect($agentsContent)->toBeString();
    expect($agentsContent)->not->toContain(':if_include_');
    expect($agentsContent)->not->toContain(':endif_include_');
    expect($agentsContent)->not->toContain(':package_slug');
    expect($agentsContent)->toContain('## Agent rules');
    expect($agentsContent)->toContain('composer test');

    $expectedAgents = [
        'architect.md',
        'package-developer.md',
        'security.md',
        'performance.md',
        'reviewer.md',
        'testing.md',
        'database.md',
        'api.md',
    ];
    foreach ($expectedAgents as $agent) {
        $agentFile = $agentsPath . '/' . $agent;
        expect($agentFile)->toBeFile();
        $frontmatter = file_get_contents($agentFile);
        expect($frontmatter)->toBeString();
        expect($frontmatter)->toStartWith('---');
        expect($frontmatter)->toContain('description:');
        expect($frontmatter)->toContain('mode: subagent');
    }

    $expectedSkills = [
        'package-development',
        'laravel-package',
        'testing',
        'api',
        'database',
        'code-review',
        'release',
    ];
    foreach ($expectedSkills as $skill) {
        $skillDir = $skillsPath . '/' . $skill;
        expect($skillDir)->toBeDirectory();
        expect($skillDir . '/SKILL.md')->toBeFile();
        expect($skill)->toMatch('/^[a-z0-9]+(-[a-z0-9]+)*$/');
        $skillContent = file_get_contents($skillDir . '/SKILL.md');
        expect($skillContent)->toBeString();
        expect($skillContent)->toStartWith('---');
        expect($skillContent)->toContain('description:');
        expect($skillContent)->toContain('name: ' . $skill);
    }

    aiDeleteDir($tempDir);
});

test('feature-aware agents and skills are omitted when tests, migrations or API routes are not included', function () {
    $tempDir = __DIR__ . '/../ai-feature-aware-test';
    aiGeneratePackage([
        'include_migration' => false,
        'include_routes' => false,
        'route_type' => 'none',
        'include_tests' => false,
    ], $tempDir);

    $agentsPath = $tempDir . '/.opencode/agents';
    $skillsPath = $tempDir . '/.opencode/skills';

    expect($agentsPath . '/testing.md')->not->toBeFile();
    expect($agentsPath . '/database.md')->not->toBeFile();
    expect($agentsPath . '/api.md')->not->toBeFile();
    expect($skillsPath . '/testing')->not->toBeDirectory();
    expect($skillsPath . '/database')->not->toBeDirectory();
    expect($skillsPath . '/api')->not->toBeDirectory();

    expect($agentsPath . '/architect.md')->toBeFile();
    expect($agentsPath . '/package-developer.md')->toBeFile();
    expect($skillsPath . '/package-development/SKILL.md')->toBeFile();

    aiDeleteDir($tempDir);
});

test('Claude compatibility and Copilot instructions are generated when enabled', function () {
    $tempDir = __DIR__ . '/../ai-compat-test';
    aiGeneratePackage([
        'include_claude_compatibility' => true,
        'include_copilot_instructions' => true,
    ], $tempDir);

    $claudeFile = $tempDir . '/CLAUDE.md';
    $copilotFile = $tempDir . '/.github/copilot-instructions.md';

    expect($claudeFile)->toBeFile();
    $claudeContent = file_get_contents($claudeFile);
    expect($claudeContent)->toBeString();
    expect($claudeContent)->toContain('@AGENTS.md');

    expect($copilotFile)->toBeFile();
    $copilotContent = file_get_contents($copilotFile);
    expect($copilotContent)->toBeString();
    expect($copilotContent)->toContain('AGENTS.md');

    aiDeleteDir($tempDir);
});

test('AGENTS.md only mentions the development tools that were selected', function () {
    $tempDir = __DIR__ . '/../ai-tools-test';
    aiGeneratePackage([
        'use_pint' => true,
        'use_phpstan' => false,
        'use_psalm' => false,
        'use_rector' => false,
        'use_commitlint' => false,
    ], $tempDir);

    $agentsContent = file_get_contents($tempDir . '/AGENTS.md');
    expect($agentsContent)->toBeString();
    expect($agentsContent)->toContain('composer format');
    expect($agentsContent)->toContain('Laravel Pint');
    expect($agentsContent)->not->toContain('composer analyse');
    expect($agentsContent)->not->toContain('composer psalm');
    expect($agentsContent)->not->toContain('composer refactor');
    expect($agentsContent)->not->toContain('npm run commit');

    aiDeleteDir($tempDir);
});

test('AGENTS.md reflects excluded package features', function () {
    $tempDir = __DIR__ . '/../ai-features-test';
    aiGeneratePackage([
        'include_migration' => false,
        'include_config' => false,
        'include_routes' => false,
        'include_translations' => false,
        'include_assets' => false,
        'include_views' => false,
        'include_command' => false,
        'include_facade' => false,
        'include_tests' => false,
    ], $tempDir);

    $agentsContent = file_get_contents($tempDir . '/AGENTS.md');
    expect($agentsContent)->toBeString();
    expect($agentsContent)->not->toContain('database/migrations/');
    expect($agentsContent)->not->toContain('vendor:publish --tag');
    expect($agentsContent)->not->toContain('routes/web.php');
    expect($agentsContent)->not->toContain('routes/api.php');
    expect($agentsContent)->not->toContain('resources/views/');
    expect($agentsContent)->not->toContain('resources/lang/');
    expect($agentsContent)->not->toContain('resources/css/');
    expect($agentsContent)->not->toContain('src/Commands/');
    expect($agentsContent)->not->toContain('src/Facades/');
    expect($agentsContent)->not->toContain('composer test');

    aiDeleteDir($tempDir);
});