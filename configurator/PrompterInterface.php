<?php

declare(strict_types=1);

namespace Configurator;

interface PrompterInterface
{
    public function promptAuthorName(): string;
    public function promptAuthorEmail(): string;
    public function promptAuthorUsername(): string;
    public function promptVendorName(?string $defaultName = null): string;
    public function promptVendorNamespace(?string $defaultNamespace = null): string;
    public function promptPackageName(?string $defaultName = null): string;
    public function promptClassName(?string $defaultClassName = null): string;
    public function promptDescription(?string $defaultDescription = null): string;
    public function promptLicense(): string;
    public function promptIncludeFunding(): bool;
    public function promptPhpVersion(): string;
    public function promptLaravelVersion(): string;
    public function promptIncludeMigration(): bool;
    public function promptIncludeConfig(): bool;
    public function promptIncludeRoutes(): bool;
    public function promptRouteType(): string;
    public function promptIncludeTranslations(): bool;
    public function promptIncludeAssets(): bool;
    public function promptIncludeViews(): bool;
    public function promptIncludeCommand(): bool;
    public function promptIncludeFacade(): bool;
    public function promptIncludeTests(): bool;
    public function promptEnablePint(): bool;
    public function promptEnablePhpStan(): bool;
    public function promptEnablePsalm(): bool;
    public function promptEnableRector(): bool;
    public function promptProceed(): bool;
    public function promptComposerInstall(): bool;
    public function promptCleanup(): bool;
}
