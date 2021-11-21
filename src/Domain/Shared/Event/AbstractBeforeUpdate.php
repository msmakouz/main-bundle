<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;

class AbstractBeforeUpdate
{
    private UpdateCommandInterface $command;

    public function __construct(UpdateCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UpdateCommandInterface
    {
        return $this->command;
    }
}
