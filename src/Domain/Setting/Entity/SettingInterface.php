<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Entity;

use Zentlix\MainBundle\Application\Command\Setting\SettingCommandInterface;

interface SettingInterface
{
    public function change(SettingCommandInterface $command): void;
}
