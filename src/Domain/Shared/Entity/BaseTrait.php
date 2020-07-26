<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Entity;

use Doctrine\ORM\Mapping;

trait BaseTrait
{
    /** @Mapping\Column(type="json", nullable=true) */
    private $base_for_sites;

    public function isBaseForSite(int $siteId): bool
    {
        if(!is_array($this->base_for_sites)) {
            return false;
        }

        return in_array($siteId, $this->base_for_sites);
    }

    public function getBaseForSites(): array
    {
        return is_array($this->base_for_sites) ? $this->base_for_sites : [];
    }

    public function disableBase(array $sites): void
    {
        foreach ($sites as $site) {
            if($this->isBaseForSite($site)) {
                unset($this->base_for_sites[array_search($site, $this->base_for_sites)]);
            }
        }

        $this->base_for_sites = array_values($this->base_for_sites);
    }
}