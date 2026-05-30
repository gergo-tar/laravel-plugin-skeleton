# Laravel Package Skeleton

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gergo-tar/laravel-package-skeleton.svg?style=flat-square)](https://packagist.org/packages/gergo-tar/laravel-package-skeleton)

This package provides a modern, interactive skeleton for building Laravel packages with best practices and essential development tools.

## Requirements

- PHP >= 8.3
- Composer

## 🚀 How It Works

1. **Clone the skeleton:**
    ```bash
    git clone https://github.com/gergo-tar/laravel-plugin-skeleton my-package
    cd my-package
    ```
2. **Run the configuration script:**
   First, run Composer's autoloader dump to ensure classes are properly loaded:

    ```bash
    composer dump-autoload
    ```

    Run the configurator:

    ```bash
    php configure.php
    ```

    - The script will prompt for author, vendor, package, and feature options.
    - Based on your selections, it generates all necessary files, and cleans up unused templates.

3. **Start developing your package!**
    - All selected features (config, migrations, commands, etc.) are ready to use.
    - Testing infrastructure (Pest) and dev tools (PHPStan, Rector, Psalm, PHPCS, PHP-CS-Fixer) are pre-configured.

## ✨ Available Options

At the start of each group you can answer **yes** to "Include/Enable ALL …?" to skip individual prompts, or answer **no** to choose one by one.

### Package Features

| Feature      | What it generates                                      |
| ------------ | ------------------------------------------------------ |
| Migrations   | `database/migrations/create_<package>_table.php`       |
| Config       | `config/<package>.php`, published via `vendor:publish` |
| Routes       | `routes/web.php`, `routes/api.php`, or both            |
| Views        | `resources/views/` directory                           |
| Translations | `resources/lang/en/messages.php`                       |
| Assets       | `resources/css/` and `resources/js/` directories       |
| Commands     | `src/Commands/<ClassName>Command.php`                  |
| Facade       | `src/Facades/<ClassName>Facade.php`                    |
| Tests        | `tests/Feature/`, `tests/Unit/`, `phpunit.xml`         |

### Development Tools

| Tool                    | Purpose                                                       |
| ----------------------- | ------------------------------------------------------------- |
| Commitlint + Commitizen | Enforces conventional commit messages, interactive commit CLI |
| Pint                    | Laravel code style fixer                                      |
| PHPStan (Larastan)      | Static analysis with Laravel-specific rules                   |
| Psalm                   | Type-safety focused static analysis                           |
| Rector                  | Automated code refactoring                                    |
| Coverage (Codecov)      | CI test coverage reporting via Codecov                        |

### GitHub Integrations

| Integration     | What it generates                                               |
| --------------- | --------------------------------------------------------------- |
| Funding         | `.github/FUNDING.yml`                                           |
| Security Policy | `.github/SECURITY.md`                                           |
| Support Policy  | `.github/SUPPORT.md`                                            |
| Code of Conduct | `.github/CODE_OF_CONDUCT.md`                                    |
| Issue Templates | `.github/ISSUE_TEMPLATE/bug_report.yml` + `feature_request.yml` |
| PR Template     | `.github/pull_request_template.md`                              |

## 🖥️ Generation Flow Examples

### Example: full package with all options enabled

```text
╔══════════════════════════════════════════════════════════════╗
║          Laravel Package Skeleton Configuration              ║
╚══════════════════════════════════════════════════════════════╝


📝 Author Information
────────────────────────────────────────────────────────────────
Author name [Gergő Tar]:
Author email [dev@gergotar.com]:
Author username (GitHub): gergotar

📦 Package Information
────────────────────────────────────────────────────────────────
Vendor name (e.g., your GitHub username or organization) [gergotar]:
Vendor namespace (e.g., YourGitHubUsernameOrOrganization) [Gergotar]:
Package name [laravel-plugin-skeleton (copy)]: laravel-feature-flags
Class name [LaravelFeatureFlags]:
Package description [This is my package laravel-feature-flags]: Feature flag management for Laravel applications
Select license
  [1] MIT
  [2] GPL-3.0
  [3] Apache-2.0
  [4] BSD-3-Clause
  [5] BSD-2-Clause
  [6] LGPL-3.0
  [7] Unlicensed
Select option [1]:

⚙️  Version Requirements
────────────────────────────────────────────────────────────────
PHP version requirement
  [1] ^8.3
  [2] ^8.4
  [3] ^8.5
  [4] ^8.3|^8.4
  [5] ^8.4|^8.5
  [6] ^8.3|^8.4|^8.5
Select option [6]:
Laravel version support
  [1] ^11
  [2] ^12
  [3] ^13
Select option [3]:
Main branch name [main]:

✨ Feature Selections
────────────────────────────────────────────────────────────────

Select features to include:

Include ALL features? (yes/no) [no]: yes

🛠️  Development Tool Selections
────────────────────────────────────────────────────────────────
Enable ALL development tools? (yes/no) [no]: yes

🐙 GitHub Integration
────────────────────────────────────────────────────────────────
Include ALL GitHub integrations? (yes/no) [no]: yes

📋 Configuration Summary
────────────────────────────────────────────────────────────────
Author       : Gergő Tar (gergotar, dev@gergotar.com)
Vendor       : gergotar (gergotar)
Package      : laravel-feature-flags <Feature flag management for Laravel applications>
Namespace    : Gergotar\LaravelFeatureFlags
Class name   : LaravelFeatureFlags
License      : MIT
PHP Version  : ^8.3|^8.4|^8.5
Laravel      : ^13
Git Branch   : main

Features:
  Migrations     : yes
  Config         : yes
  Views          : yes
  Routes         : both
  Translations   : yes
  Assets         : yes
  Commands       : yes
  Facade         : yes

Dev Tools:
  Commitlint     : yes
  Tests          : yes
  Pint           : yes
  PHPStan        : yes
  Rector         : yes
  Psalm          : yes
  Coverage       : yes (Codecov)

GitHub Integration:
  Funding        : yes
  Security Policy: yes
  Support Policy : yes
  Code of Conduct: yes
  Issue Templates: yes
  PR Template    : yes
══════════════════════════════════════════════════════════════

Proceed with the above configuration? (yes/no) [yes]: yes

🔧 Finalizing Package Setup

Execute `composer install`? (yes/no) [yes]:

🚀 Running composer install...

No composer.lock file present. Updating dependencies to latest instead of installing from lock file.
Loading composer repositories with package information
Updating dependencies
Lock file operations: 162 installs, 0 updates, 0 removals
Installing dependencies from lock file (including require-dev)
Generating autoload files
A config file already exists in the current directory

✅ Package structure generated successfully!

🎉 Your package is ready!

Next steps:
  1. Review the generated files
  2. Start coding in src/
  3. Write your tests in tests/
  4. Run: composer test
  5. Run: composer format
  5. Run: composer analyse

Let this script delete itself? (yes/no) [yes]:

🧹 Cleanup completed. Configuration files have been removed.
```

### Example: choosing options one by one

```text
📝 Author Information
────────────────────────────────────────────────────────────────
Author name [Gergő Tar]:
Author email [dev@gergotar.com]:
Author username (GitHub): gergotar

📦 Package Information
────────────────────────────────────────────────────────────────
Vendor name (e.g., your GitHub username or organization) [gergotar]:
Vendor namespace (e.g., YourGitHubUsernameOrOrganization) [Gergotar]:
Package name [laravel-plugin-skeleton (another copy)]: laravel-banner-manager
Class name [LaravelBannerManager]:
Package description [This is my package laravel-banner-manager]: Manage announcement banners across a Laravel app
Select license
  [1] MIT
  [2] GPL-3.0
  [3] Apache-2.0
  [4] BSD-3-Clause
  [5] BSD-2-Clause
  [6] LGPL-3.0
  [7] Unlicensed
Select option [1]:

⚙️  Version Requirements
────────────────────────────────────────────────────────────────
PHP version requirement
  [1] ^8.3
  [2] ^8.4
  [3] ^8.5
  [4] ^8.3|^8.4
  [5] ^8.4|^8.5
  [6] ^8.3|^8.4|^8.5
Select option [6]:
Laravel version support
  [1] ^11
  [2] ^12
  [3] ^13
Select option [3]:
Main branch name [main]:

✨ Feature Selections
────────────────────────────────────────────────────────────────
Select features to include:

Include ALL features? (yes/no) [no]: no
Include migration file? (yes/no) [yes]:
Include configuration file? (yes/no) [yes]:
Include routes? (yes/no) [no]:
Include translations? (yes/no) [no]:
Include assets (CSS/JS)? (yes/no) [no]:
Include views? (yes/no) [no]:
Include Artisan command? (yes/no) [no]:
Include Facade? (yes/no) [no]:
Include test files? (yes/no) [no]:

🛠️  Development Tool Selections
────────────────────────────────────────────────────────────────
Enable ALL development tools? (yes/no) [no]:
Use commitlint, commitizen and semantic versioning? (yes/no) [yes]:
Enable Pint (code style)? (yes/no) [yes]:
Enable PHPStan (Larastan)? (yes/no) [yes]:
Enable Psalm (with psalm-plugin-laravel)? (yes/no) [yes]:
Enable Rector? (yes/no) [no]:
Enable coverage reporting (Codecov)? (yes/no) [no]:

🐙 GitHub Integration
────────────────────────────────────────────────────────────────
Include ALL GitHub integrations? (yes/no) [no]: no
Include funding information? (yes/no) [no]:
Include security policy (SECURITY.md)? (yes/no) [no]:
Include support policy (SUPPORT.md)? (yes/no) [no]:
Include code of conduct? (yes/no) [no]:
Include GitHub issue templates? (yes/no) [no]: yes
Include pull request template? (yes/no) [no]: yes

📋 Configuration Summary
────────────────────────────────────────────────────────────────
Author       : Gergő Tar (gergotar, dev@gergotar.com)
Vendor       : gergotar (gergotar)
Package      : laravel-banner-manager <Manage announcement banners across a Laravel app>
Namespace    : Gergotar\LaravelBannerManager
Class name   : LaravelBannerManager
License      : MIT
PHP Version  : ^8.3|^8.4|^8.5
Laravel      : ^13
Git Branch   : main

Features:
  Migrations     : yes
  Config         : yes
  Views          : no
  Routes         : no
  Translations   : no
  Assets         : no
  Commands       : no
  Facade         : no

Dev Tools:
  Commitlint     : yes
  Tests          : no
  Pint           : yes
  PHPStan        : yes
  Rector         : no
  Psalm          : yes
  Coverage       : no

GitHub Integration:
  Funding        : no
  Security Policy: no
  Support Policy : no
  Code of Conduct: no
  Issue Templates: yes
  PR Template    : yes
══════════════════════════════════════════════════════════════

Proceed with the above configuration? (yes/no) [yes]:

🔧 Finalizing Package Setup

Execute `composer install`? (yes/no) [yes]:

🚀 Running composer install...

No composer.lock file present. Updating dependencies to latest instead of installing from lock file.
Loading composer repositories with package information
Updating dependencies
Lock file operations: 111 installs, 0 updates, 0 removals
Installing dependencies from lock file (including require-dev)
Generating autoload files
A config file already exists in the current directory

✅ Package structure generated successfully!

🎉 Your package is ready!

Next steps:
  1. Review the generated files
  2. Start coding in src/
  3. Run: composer format
  3. Run: composer analyse

Let this script delete itself? (yes/no) [yes]:

🧹 Cleanup completed. Configuration files have been removed.
```

## 📁 What Gets Generated

Based on your selections, the configurator generates and updates:

- Package metadata (`composer.json`, optional `package.json` workflows)
- Service provider and optional package classes under `src/`
- Optional resources: `config/`, `database/migrations/`, `resources/views/`, `resources/lang/`, `resources/css/`, `resources/js/`
- Optional route files under `routes/` (API, web, or both)
- Test structure under `tests/`
- Optional GitHub governance and community templates under `.github/` (issue/PR templates, code of conduct, support, security)
- Optional quality/config files (PHPStan, Rector, Pint, commitlint, release tooling)

## 🧪 Useful Commands

These commands are for development in the generated package.

### Composer scripts

```bash
composer test     # Run Pest test suite
composer stan     # Run PHPStan on configurator and tests
composer cs       # Run PHPCS checks
composer cs-fix   # Auto-fix style issues with PHP-CS-Fixer
composer rector   # Run Rector refactoring rules
composer psalm    # Run Psalm static analysis
```

Composer scripts are included in generated packages. Some scripts may be removed if you disable the related tool during configuration.

### npm scripts (optional)

```bash
npm run commit    # Interactive conventional commit (Commitizen)
npm run release   # Version/changelog release (standard-version)
```

These npm scripts are only generated when you enable commitlint/commitizen/semantic versioning in the configurator.

## 📦 Usage

- After configuration, your package is ready for local development or publishing.
- See [`CONFIGURATION`](./CONFIGURATION.md) for a full guide to the configuration process and available features.

## 🧾 Versioning and Changelog

- Conventional commit workflow is supported via Commitizen + Commitlint.
- Release notes/changelog can be generated with `standard-version`.
- Changelog formatting is additionally supported by `cliff.toml`.

## 📄 License

MIT. See [LICENSE](LICENSE.md) for more information.

---

**Your package, your way, in seconds! 🚀**
