<?php

declare(strict_types=1);

namespace Configurator;

interface PrompterInterface
{
    public function promptAuthorName(): string;
    public function promptAuthorEmail(): string;
    public function promptAuthorUsername(): string;
    public function promptClassName(?string $defaultClassName = null): string;
    public function promptCleanup(): bool;
    public function promptComposerInstall(): bool;
    public function promptDescription(?string $defaultDescription = null): string;
    public function promptEnableCommitLint(): bool;
    public function promptEnablePint(): bool;
    public function promptEnablePhpStan(): bool;
    public function promptEnablePsalm(): bool;
    public function promptEnableRector(): bool;
    public function promptIncludeAssets(): bool;
    public function promptIncludeCommand(): bool;
    public function promptIncludeConfig(): bool;
    public function promptIncludeFacade(): bool;
    public function promptIncludeFunding(): bool;
    public function promptIncludeCoverageReporting(): bool;
    public function promptIncludeSecurityPolicy(): bool;
    public function promptIncludeSupportPolicy(): bool;
    public function promptIncludeCodeOfConduct(): bool;
    public function promptIncludeIssueTemplates(): bool;
    public function promptIncludePullRequestTemplate(): bool;
    public function promptIncludeMigration(): bool;
    public function promptIncludeRoutes(): bool;
    public function promptIncludeTests(): bool;
    public function promptIncludeTranslations(): bool;
    public function promptIncludeViews(): bool;

    public function promptLaravelVersion(): string;
    public function promptLicense(): string;
    public function promptMainBranchName(): string;
    public function promptPackageName(?string $defaultName = null): string;
    public function promptPhpVersion(): string;
    public function promptProceed(): bool;
    public function promptRouteType(): string;
    public function promptVendorName(?string $defaultName = null): string;
    public function promptVendorNamespace(?string $defaultNamespace = null): string;
}
