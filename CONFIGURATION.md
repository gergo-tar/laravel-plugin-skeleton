# Configuration Guide

This document explains how the configuration process works and what features this Laravel package skeleton provides.

## 🛠️ What Does This Package Provide?

This skeleton helps you quickly scaffold a modern Laravel package with:

-   Interactive configuration script (`configure.php`)
-   Composer and PSR-4 setup
-   Service provider and optional features (migrations, config, commands, etc.)
-   Testing infrastructure (Pest)
-   Pre-configured dev tools (PHPStan, Rector, Pint)
-   Clean-up of unused files based on your choices

## 🚀 How the Configuration Process Works

1. **Clone the repository and run the script:**
    ```bash
    git clone https://github.com/gergo-tar/laravel-plugin-skeleton my-package
    cd my-package
    php configure.php
    ```
2. **Answer the prompts:**
    - Author, vendor, and package info (auto-detected where possible)
    - Choose which features to include (migrations, config, views, routes, translations, assets, commands, facade, funding)
    - Select dev tools (PHPStan, Rector, Pint)
    - Set PHP and Laravel version requirements
3. **Review the summary:**
    - See a clear summary of your selections before proceeding
4. **Automatic file generation:**
    - The script generates all necessary files and directories for your chosen features
    - Unused stubs and templates are removed for a clean result
5. **Ready to develop:**
    - All selected features and tools are pre-configured
    - Start building your package right away

## 📦 Features You Can Include

You can choose to include any of the following:

-   **Migrations** (`database/migrations/`)
-   **Config file** (`config/`)
-   **Views** (`resources/views/`)
-   **Routes** (`routes/web.php`, `routes/api.php`)
-   **Translations** (`resources/lang/`)
-   **Assets** (`resources/css/`, `resources/js/`)
-   **Artisan Commands** (`src/Commands/`)
-   **Facade** (`src/Facades/`)
-   **FUNDING file** (`.github/FUNDING.yml`)

## 🧩 Dev Tools

The following tools can be enabled for code quality and automation:

-   **PHPStan (Larastan)**: Static analysis
-   **Rector**: Automated refactoring
-   **Pint**: Code style fixer
-   **Pest**: Modern testing framework

## 📝 Example Configuration Summary

After answering the prompts, you'll see a summary like:

```
📋 Configuration Summary
────────────────────────────────────────────────────────────────
Author       : Alex Developer (alexdev, alex@example.com)
Vendor       : UsefulTools (usefultools)
Package      : laravel-activity-logger <Tracks user activity in your Laravel app>
Namespace    : UsefulTools\LaravelActivityLogger
Class name   : LaravelActivityLogger
License      : MIT
PHP Version  : ^8.3
Laravel      : ^12.0

Features:
  Migrations     : yes
  Config         : yes
  Views          : no
  Routes         : web
  Translations   : no
  Assets         : yes
  Commands       : no
  Facade         : no

Dev Tools:
  Pint           : yes
  PHPStan        : yes
  Rector         : yes
══════════════════════════════════════════════════════════════
```

## 🏁 Quick Start

1. Clone the skeleton and run the configuration script
2. Answer the prompts
3. Start developing your package!

---

For more details, see the [README](./README.md).
