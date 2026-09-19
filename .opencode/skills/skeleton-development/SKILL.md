---
name: skeleton-development
description: How to develop the Laravel Package Skeleton — the configurator's five layers, stub template syntax, how features flow through prompts/output/structure/generation, and how the AI-agent templates in configurator/Stubs/ai are maintained.
license: MIT
compatibility: opencode
---

# Skeleton Development

Use this skill when implementing, changing, or reviewing features of Laravel Package Skeleton —
the tool that turns this repository into a Laravel package by running `php configure.php`.

This skill's root instructions and hard rules live in `AGENTS.md`; use them together.

## The five-layer flow

Every user-facing feature that the generated package can include is wired through five layers.
A feature is only done when **all** of them are updated:

1. **Options** — `configurator/Options/` enums, when the feature is a choice (PHP/Laravel
   versions, licenses, route types).
2. **Prompts** — a method on `PrompterInterface`, implemented in `ConfiguratorPrompter`
   (real dialog via `ConfigUtil`) and `tests/TestPrompter` (canned answers). Prompts that
   toggle a group follow the "Include ALL …?" select-all pattern, defaulting to `no` and
   short-circuiting the individual questions on `yes`.
3. **Output** — show the selection in the `ConfiguratorOutput` summary block.
4. **Structure constants** — `configurator/Structure/<Concern>.php`: `FOLDER`, `FILE_NAME`,
   `STUB` constants and `get*Path()` getters, all resolved from `ConfiguratorGlobals::getBasePath()`.
5. **Generation** — the `.stub` template in `configurator/Stubs/`, a mapping in
   `PackageConfigurator::getStubMappings()` (`stub => [dest, create-folder]`), placeholders in
   `processStubsAndFiles()`, and any conditional processing in the relevant `update*File()`.
   If the feature leaves files in the template repo that must vanish from generated projects,
   add them to the cleanup list in `run()`.

## Placeholders

`ConfigUtil::replaceInFile($file, [...])` replaces tokens once per copied file in
`processStubsAndFiles()`. Every `:token` in a stub must exist in that map:

- Identifiers: `:author_name`, `:author_username`, `:author_email`, `:vendor_name`,
  `:vendor_slug`, `:package_name`, `:package_slug`, `:package_slug_underscored`,
  `:package_slug_upper_`, `:namespace`, `:composer_namespace`, `:class_name`,
  `:service_provider_name`, `:variable`, `:command_name` (the package slug / artisan signature).
- Versions: `:php_version`, `:php_version_comma_separated`, `:laravel_version`,
  `:laravel_version_number`, `:testbench_version`.
- Tools: `:phpstan_job`, `:pint_job`, `:psalm_job`, `:code_quality_tools`, `:command_class`,
  `:license`, `:main_branch`.

## Conditional blocks

`ConfigUtil::processConditionalBlocks($file, ['feature' => bool])` resolves `:if_feature ...
:endif_feature` blocks (optionally with `:else`), stripping the marker lines.

- Process **outer blocks before inner blocks**: the regex consumes up to the first
  `:endif_feature` for a name, so different features may nest, but a feature must never nest
  inside itself.
- Per-file condition arrays differ (README uses `include_workflow`, the service provider uses
  `include_web_routes`/`include_api_routes`, AGENTS.md uses per-tool keys like `include_pint`,
  `use_commitlint`) — keep each `update*File()` array aligned with that stub's markers.

## Tests

- Pest, `tests/Unit/`. Canned flow via `tests/TestPrompter`.
- Tests generate packages into temp directories, inspect key files/tokens/conditional results,
  then clean up.
- Global helper functions must have **per-file unique names** (Pest loads everything into one
  process). Prefix new helpers with a file-specific string.
- Keep generated-package assertions loose — templates change wording between releases.

## Maintaining the AI-agent templates (`configurator/Stubs/ai/`)

The AI feature set is itself a feature of the skeleton and follows the same five-layer flow:

- **Prompts**: `promptEnableAiSupport`, `promptSelectAllAiFeatures`, `promptIncludeAgentsMd`,
  `promptIncludeOpenCodeAgents`, `promptIncludeOpenCodeSkills`,
  `promptIncludeClaudeCompatibility`, `promptIncludeCopilotInstructions`.
- **Defaults** (in `configurator/Structure/Ai.php`): AI support on, AGENTS.md on, OpenCode
  agents on, skills on, Claude Code and Copilot off.
- **Mapping rules** (in `PackageConfigurator::addAiStubMappings()`):
  - `AGENTS.md` always (when AI support on + AGENTS.md selected); Codex compatibility is
    derived from it (no separate file).
  - `CLAUDE.md` only when Claude compatibility is selected — it references `AGENTS.md` via
    `@AGENTS.md`.
  - `copilot-instructions.md` under `.github/` only when Copilot instructions are selected.
  - Agents/skills: `testing` gated on `includeTests`, `database` on `includeMigration`,
    `api` on routes being API or both. The rest are unconditional.
- **AGENTS.md conditions**: `updateAgentsFile()` resolves feature and tool conditional blocks
  (`include_config`, `include_migration`, `include_translations`, `include_views`,
  `include_assets`, `include_command`, `include_facade`, `include_web_routes`,
  `include_api_routes`, `include_tests`, `include_pint`, `include_phpstan`, `include_psalm`,
  `include_rector`, `use_commitlint`) — keep them in sync with `AGENTS.md.stub` marker names.

## Checklist before reporting completion

1. All five layers updated for the feature.
2. New/changed stub validated by generating a sample package and inspecting the output.
3. `composer test`, `composer stan`, `composer psalm`, `composer cs` pass for the touched files.
4. `composer rector` introduces no unexpected refactors.
5. `git diff` reviewed end to end.