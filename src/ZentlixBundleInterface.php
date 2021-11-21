<?php

declare(strict_types=1);

namespace Zentlix\MainBundle;

interface ZentlixBundleInterface
{
    public function getTitle(): string;

    public function getVersion(): string;

    public function getDescription(): string;

    public function getDeveloper(): array;

    public function configureRights(): array;

    public function getSettingsClass(): ?string;

    public function getSettingsForm(): ?string;

    public function getBundleName(): string;

    public function isPackageRequired(string $package): bool;

    public function getRequire(): array;

    public function isSystem(): bool;
}
