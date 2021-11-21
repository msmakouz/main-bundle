<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Infrastructure\Share\Bus\CreateCommandInterface;

class AbstractBeforeCreate
{
    private CreateCommandInterface $command;

    public function __construct(CreateCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): CreateCommandInterface
    {
        return $this->command;
    }
}
