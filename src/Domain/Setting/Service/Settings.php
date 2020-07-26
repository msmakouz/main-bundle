<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Service;

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;

class Settings {

    private ?Setting $settings;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->settings = $entityManager->getRepository(Setting::class)->findOneBy([]);

        if(is_null($this->settings)) {
            throw new \DomainException('Main bundle settings not found, please install bundle correctly.');
        }
    }

    public function getDefaultLocale()
    {
        return $this->settings->getDefaultLocale();
    }
}