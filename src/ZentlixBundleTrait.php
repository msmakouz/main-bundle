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
    public function getVersion(): string
    {
        // TODO: Implement getVersion() method.
    }

    public function install(): void
    {
        // TODO: Implement install() method.
    }

    public function uninstall(): void
    {
        // TODO: Implement uninstall() method.
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
}