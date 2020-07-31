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

use Zentlix\MainBundle\Domain\Site\Entity\Site;

trait ZentlixBundleTrait
{
    public function getBundleName(): string
    {
        $composerJson = $this->parseComposerJson();

        return $composerJson['name'];
    }

    private function parseComposerJson(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $composerJson = \dirname($reflector->getFileName(), 2) . DIRECTORY_SEPARATOR . 'composer.json';

        if ($data = file_get_contents($composerJson)) {
            $package = json_decode($data, true);

            if (0 < $errorCode = json_last_error()) {
                throw new \Exception(sprintf('Error parsing composer.json: %s', $composerJson));
            }
        }

        return $package;
    }

    // OVERRIDES IN BUNDLE MAIN FILE
    /**
     * @return array
     */
    public function configureRights(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function installFrontendRoutes(): array
    {
        return [];
    }

    public function installMailerEvents(): array
    {
        return [];
    }

    public function installFrontendRoutesForSite(Site $site)
    {

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