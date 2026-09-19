# Laravel Package Skeleton

This repository is **a scaffolding tool**, not a Laravel package and not a Laravel application.
It turns this cloned repository into a ready-to-develop Laravel package by running
`php configure.php`. Everything user-facing is only relevant **before** configuration runs.

The generated scaffolding conventions (Laravel package development, Composer constraints,
service providers) live in `configurator/Stubs/ai/` templates that are copied into generated
projects — see the `skeleton-development` skill for how those are maintained.

## What this project is

- A source-only template plus a PHP configurator (`configure.php` → `PackageConfigurator`).
- Users clone the repo, run `composer dump-autoload && php configure.php`, answer prompts, and
  receive a fully configured package project. The configurator then deletes itself and the
  leftover skeleton files.
- The codebase is plain PHP >= 8.3 with no runtime framework dependency. All source lives in
  `configurator/` under the `Configurator\` namespace.

## Repository structure

- `configure.php` — entry point; it runs `PackageConfigurator::run()`.
- `configurator/` — all logic and templates (the part that is compiled/type-checked heavily).
  - `PackageConfigurator.php` — orchestration: collects selections, stubs, placeholders,
    conditional processing, cleanup, and the Run AWAY generation flow.
  - `ConfiguratorPrompter.php` + `PrompterInterface.php` — interactive prompts. Every interactive
    question is a method on the interface, implemented by the prompter and by `TestPrompter`.
  - `ConfiguratorOutput.php` — the ASCII-art summary and progress output.
  - `ConfigUtil.php` — `ask`, `confirm`, `choice`, `replaceInFile`, `processConditionalBlocks`,
    filesystem helpers, `slug`, `titleCase`.
  - `Options/` — enums for PHP/laravel versions, licenses, route types.
  - `Structure/` — path/file-name/stub constants and getters per concern (Composer, Docs,
    GitHub, Src, Test, Tools, Ai, …).
  - `Stubs/` — every template shipped into generated projects (`.stub` files), including the
    `ai/` subtree containing the AGENTS.md/agent/skill templates.
- `tests/` — Pest tests. `TestPrompter` implements the prompt interface with canned answers.
  Tests generate packages into temp directories and copy the templates to verify them.

## Development commands

Install dependencies with `composer install` and `npm install`.

```bash
composer test     # Pest test suite (tests configurator + template generation)
composer stan     # PHPStan analysis configurator tests --level=max
composer cs       # PHPCS checks configurator
composer cs-fix   # PHP-CS-Fixer auto-fix configurator
composer rector   # Rector refactoring configurator
composer psalm    # Psalm analysis --show-info=true
```

Use `npm run commit` for conventional commits (Commitizen + commitlint are enforced).

## Development conventions

### How a feature flows through the configurator

Every user-facing feature is wired through the same five layers. When adding or changing a
feature, update **all** of them:

1. **Options** (`configurator/Options/...`) — the selectable choices, if it is a choice.
2. **Prompts** — a method on `PrompterInterface`, implemented in `ConfiguratorPrompter` (real
   dialog) and `tests/TestPrompter` (canned answers for tests). Follow the existing "Include
   ALL …?" select-all pattern where a prompt applies.
3. **Output** — show the selections in `ConfiguratorOutput` summary blocks.
4. **Structure constants** (`configurator/Structure/...`) — paths, file names, and stub paths.
5. **Generation** — a stub template in `configurator/Stubs/`, a mapping entry in
   `PackageConfigurator::getStubMappings()` (array `stub => [destination, create-folder]`),
   and any post-copy `processConditionalBlocks`/`replaceInFile` step in the `update*File()`
   methods. Update the self-cleanup list in `run()` if the feature has leftover files.

### Stub template syntax

- Placeholders: `:placeholder` tokens are replaced once per file, after copying, via
  `ConfigUtil::replaceInFile` using the replacement map in `processStubsAndFiles()` (e.g.
  `:package_slug`, `:class_name`, `:namespace`, `:command_name`). Add a new key to the map if
  you introduce a placeholder.
- Conditional blocks: `:if_feature ... :endif_feature` with optional `:else`, processed with
  `ConfigUtil::processConditionalBlocks($file, ['feature' => bool])`.
  - **Inner blocks must be processed after outer blocks** — `processConditionalBlocks` matches
    the first `:endif_feature` for a given feature name, so nesting different features is fine,
    but the same feature token must not nest inside itself.
  - The `AGENTS.md` template is processed with per-feature and per-tool conditions in
    `updateAgentsFile()` (e.g. `include_pint`, `use_commitlint`).

### Rules of thumb

- **Match existing patterns** in the configurator classes; keep method names and docblock style
  consistent.
- **Templates are code.** A change to any `.stub` template must be validated by generating a
  sample package and inspecting the output (there is a test that does this).
- **Never break the generated-package contract**: the configurator runs once and deletes itself,
  so the generated project must be clean and self-sufficient.
- **Preserve compatibility** with PHP >= 8.3 and the configured analysis tools (`composer stan`,
  `composer psalm`, `composer cs`).

### Tests

- Add/extend tests in `tests/Unit/`. The main suite uses canned prompts via `TestPrompter`.
- Global helper functions defined in test files (e.g. `createDir`) must have **unique names**
  per file — Pest loads all test files into one process and duplicate function declarations
  fatal. When adding a test file, prefix its helpers with something specific to that file.
- Keep the "generated package" golden checks loose (file existence, key tokens, conditional
  presence) rather than byte-for-byte, since template wording evolves.

## Verifying changes

1. `composer test` — full suite must pass.
2. `composer stan` and `composer psalm` — no new analysis errors at `max` level.
3. `composer cs` — PHPCS clean; run `composer cs-fix` if needed.
4. `composer rector` — no unexpected refactors.
5. If templates changed, generate a throwaway package into `/tmp` with `php configure.php`
   (accept defaults) and confirm the key generated files exist and the AGENTS.md conditional
   blocks resolved before deleting the temp directory.

## Agent rules

These rules apply to every AI agent working in this repository:

1. **Inspect first.** Read the configurator layer you are changing and the files around it
   before editing; read `skeleton-development` skill for conventions.
2. **Update every layer.** A change to a user-facing option almost always touches prompts,
   output, structure constants, generation, tests, and docs at once.
3. **Keep templates in sync.** Whenever you change a template or the AGENTS.md conditions/dest,
   update the corresponding Structure constants and stub mappings together.
4. **Write tests.** New behaviour ships with tests that run through `composer test`.
5. **Run the relevant checks.** Actually run the analysis/format commands above for the files
   you touched and report real output.
6. **Inspect your diff.** Review the full diff before reporting completion.
7. **Do not modify generated artifacts.** Files produced by the configurator during testing,
   `vendor/`, `node_modules/`, lock files, and caches are never hand-edited.
8. **Report honestly.** Never claim a command passed without running it, and never claim a
   generated package is valid without generating and inspecting one.