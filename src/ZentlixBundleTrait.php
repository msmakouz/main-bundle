<?php

declare(strict_types=1);

namespace Zentlix\MainBundle;

use Composer\Json\JsonFile;
use function dirname;

trait ZentlixBundleTrait
{
    public function getBundleName(): string
    {
        $composerJson = $this->parseComposerJson();

        return $composerJson['name'];
    }

    public function isPackageRequired(string $package): bool
    {
        $composerJson = $this->parseComposerJson();

        return isset($composerJson['require'][$package]);
    }

    public function getRequire(): array
    {
        $composerJson = $this->parseComposerJson();

        return $composerJson['require'];
    }

    // OVERRIDES IN BUNDLE MAIN FILE

    public function configureRights(): array
    {
        return [];
    }

    public function getSettingsClass(): ?string
    {
        return null;
    }

    public function getSettingsForm(): ?string
    {
        return null;
    }

    public function isSystem(): bool
    {
        return false;
    }

    private function parseComposerJson(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $composerJson = new JsonFile(dirname($reflector->getFileName(), 2) . '/' . 'composer.json');

        if (false === $composerJson->exists()) {
            throw new \Exception(sprintf('Error parsing composer.json: %s', $composerJson));
        }

        return $composerJson->read();
    }
}
