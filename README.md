# Laravel Package Skeleton

This package provides a modern, interactive skeleton for building Laravel packages with best practices and essential development tools.

## 🚀 How It Works

1. **Clone the skeleton:**
    ```bash
    git clone https://github.com/gergo-tar/laravel-plugin-skeleton my-package
    cd my-package
    ```
2. **Run the configuration script:**

    ```bash
    php configure.php
    ```

    - The script will prompt for author, vendor, package, and feature options.
    - Based on your selections, it generates all necessary files, and cleans up unused templates.

3. **Start developing your package!**
    - All selected features (config, migrations, commands, etc.) are ready to use.
    - Testing infrastructure (Pest) and dev tools (PHPStan, Rector) are pre-configured.

## ✨ Conditional Features

-   **Configuration file**: Only included if selected during setup. If enabled, you can publish it with:
    ```bash
    php artisan vendor:publish --tag="my-package-config"
    ```
-   **Migrations**: Only included if selected. Publish with:
    ```bash
    php artisan vendor:publish --tag="my-package-migrations"
    ```
-   **Commands**: Only included if selected. Usage instructions will be added for each command.
-   **Facade, Views, Routes, Translations, Assets**: Documented and included only if selected.

## 🛠️ Development Tools

-   **Pest**: Modern testing framework
-   **PHPStan (Larastan)**: Static analysis
-   **Rector**: Automated refactoring
-   **Pint**: Code style fixer

## 📦 UsageUsage

-   After configuration, your package is ready for local development or publishing.
-   See [`CONFIGURATION`](./CONFIGURATION.md) for a full guide to the configuration process and available features.

## 📄 License

MIT. See [LICENSE](LICENSE.md) for more information.

---

**Your package, your way, in seconds! 🚀**
