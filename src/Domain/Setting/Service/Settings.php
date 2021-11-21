<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Service;

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;

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
        if (\is_null($this->settings)) {
            $settings = $this->entityManager->getRepository(Setting::class)->findOneBy([]);

            if (\is_null($settings)) {
                throw new \DomainException('MainBundle settings not found, please install bundle correctly.');
            }

            $this->settings = $settings;
        }

        return $this->settings;
    }
}
