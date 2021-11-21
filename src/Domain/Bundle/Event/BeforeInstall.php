<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Event;

use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\InstallCommand;

final class BeforeInstall
{
    private InstallCommand $command;

    public function __construct(InstallCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): InstallCommand
    {
        return $this->command;
    }
}
