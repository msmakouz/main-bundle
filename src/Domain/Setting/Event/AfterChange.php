<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Event;

use Zentlix\MainBundle\Domain\Setting\Entity\SettingInterface;

final class AfterChange
{
    private SettingInterface $settings;

    public function __construct(SettingInterface $settings)
    {
        $this->settings = $settings;
    }

    public function getSettings(): SettingInterface
    {
        return $this->settings;
    }
}
