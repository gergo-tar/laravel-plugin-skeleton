<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use Configurator\PrompterInterface;

/**
 * Test prompter for simulating prompt answers in tests.
 */
final class TestPrompter implements PrompterInterface
{
    /** @var array<string, string|bool> */
    private array $answers;

    /**
     * @param array<string, string|bool> $answers Predefined answers for prompts
     */
    public function __construct(array $answers)
    {
        $this->answers = $answers;
    }

    #[\Override]
    public function promptAuthorName(): string
    {
        return (string)$this->answer('author_name', 'Test User');
    }

    #[\Override]
    public function promptAuthorEmail(): string
    {
        return (string)$this->answer('author_email', 'test@example.com');
    }

    #[\Override]
    public function promptAuthorUsername(): string
    {
        return (string)$this->answer('author_username', 'testuser');
    }

    #[\Override]
    public function promptVendorName(?string $defaultName = null): string
    {
        return (string)$this->answer('vendor_name', $defaultName ?? 'TestVendor');
    }

    #[\Override]
    public function promptVendorNamespace(?string $defaultNamespace = null): string
    {
        return (string)$this->answer('vendor_namespace', $defaultNamespace ?? 'TestVendor');
    }

    #[\Override]
    public function promptPackageName(?string $defaultName = null): string
    {
        return (string)$this->answer('package_name', $defaultName ?? 'TestPackage');
    }

    #[\Override]
    public function promptClassName(?string $defaultClassName = null): string
    {
        return (string)$this->answer('class_name', $defaultClassName ?? 'TestPackage');
    }

    #[\Override]
    public function promptDescription(?string $defaultDescription = null): string
    {
        return (string)$this->answer('description', $defaultDescription ?? 'A test package');
    }

    #[\Override]
    public function promptLicense(): string
    {
        return (string)$this->answer('license', 'MIT');
    }

    #[\Override]
    public function promptIncludeFunding(): bool
    {
        return (bool)$this->answer('include_funding', true);
    }

    #[\Override]
    public function promptPhpVersion(): string
    {
        return (string)$this->answer('php_version', '^8.2');
    }

    #[\Override]
    public function promptLaravelVersion(): string
    {
        return (string)$this->answer('laravel_version', '^11.0');
    }

    #[\Override]
    public function promptIncludeMigration(): bool
    {
        return (bool)$this->answer('include_migration', true);
    }

    #[\Override]
    public function promptIncludeConfig(): bool
    {
        return (bool)$this->answer('include_config', true);
    }

    #[\Override]
    public function promptIncludeRoutes(): bool
    {
        return (bool)$this->answer('include_routes', true);
    }

    #[\Override]
    public function promptRouteType(): string
    {
        return (string)$this->answer('route_type', 'both');
    }

    #[\Override]
    public function promptIncludeTranslations(): bool
    {
        return (bool)$this->answer('include_translations', true);
    }

    #[\Override]
    public function promptIncludeAssets(): bool
    {
        return (bool)$this->answer('include_assets', true);
    }

    #[\Override]
    public function promptIncludeViews(): bool
    {
        return (bool)$this->answer('include_views', true);
    }

    #[\Override]
    public function promptIncludeCommand(): bool
    {
        return (bool)$this->answer('include_command', true);
    }

    #[\Override]
    public function promptIncludeFacade(): bool
    {
        return (bool)$this->answer('include_facade', true);
    }

    #[\Override]
    public function promptIncludeTests(): bool
    {
        return (bool)$this->answer('include_tests', true);
    }

    #[\Override]
    public function promptEnableCommitLint(): bool
    {
        return (bool)$this->answer('use_commitlint', true);
    }

    #[\Override]
    public function promptEnablePint(): bool
    {
        return (bool)$this->answer('use_pint', true);
    }

    #[\Override]
    public function promptEnablePhpStan(): bool
    {
        return (bool)$this->answer('use_phpstan', true);
    }

    #[\Override]
    public function promptEnablePsalm(): bool
    {
        return (bool)$this->answer('use_psalm', true);
    }

    #[\Override]
    public function promptEnableRector(): bool
    {
        return (bool)$this->answer('use_rector', true);
    }

    #[\Override]
    public function promptProceed(): bool
    {
        return (bool)$this->answer('proceed', true);
    }

    #[\Override]
    public function promptComposerInstall(): bool
    {
        return (bool)$this->answer('composer_install', false);
    }

    #[\Override]
    public function promptCleanup(): bool
    {
        return (bool)$this->answer('cleanup', false);
    }

    private function answer(string $key, string|bool|null $default = null): string|bool
    {
        $answer = $this->answers[$key] ?? null;

        if (is_null($answer) || $answer === '') {
            if (is_null($default)) {
                throw new InvalidArgumentException("No answer provided for key '{$key}' and no default value set.");
            }

            return $default;
        }

        return $answer;
    }
}
