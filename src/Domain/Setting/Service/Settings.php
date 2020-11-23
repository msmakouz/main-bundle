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
use function is_null;

class Settings
{
    private EntityManagerInterface $entityManager;
    private ?Setting $settings = null;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getDefaultLocale()
    {
        return $this->getSettings()->getDefaultLocale();
    }

    private function getSettings(): Setting
    {
        if(is_null($this->settings)) {
            $settings = $this->entityManager->getRepository(Setting::class)->findOneBy([]);

            if(is_null($settings)) {
                throw new \DomainException('MainBundle settings not found, please install bundle correctly.');
            }

            $this->settings = $settings;
        }

        return $this->settings;
    }
}