<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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

    private function parseComposerJson(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $composerJson = new JsonFile(dirname($reflector->getFileName(), 2) . '/' . 'composer.json');

        if ($composerJson->exists() === false) {
            throw new \Exception(sprintf('Error parsing composer.json: %s', $composerJson));
        }

        return $composerJson->read();
    }

    // OVERRIDES IN BUNDLE MAIN FILE
    /**
     * @return array
     */
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
}