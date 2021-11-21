<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Event;

use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\RemoveCommand;

final class BeforeRemove
{
    private RemoveCommand $command;

    public function __construct(RemoveCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): RemoveCommand
    {
        return $this->command;
    }
}
