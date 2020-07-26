<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Event;

use Zentlix\MainBundle\Domain\Setting\Entity\SettingInterface;

final class BeforeChange
{
    private $settings;

    public function __construct(SettingInterface $settings)
    {
        $this->settings = $settings;
    }

    public function getSettings(): SettingInterface
    {
        return $this->settings;
    }
}