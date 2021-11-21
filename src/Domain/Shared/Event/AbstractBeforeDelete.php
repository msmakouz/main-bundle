<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Infrastructure\Share\Bus\DeleteCommandInterface;

class AbstractBeforeDelete
{
    private DeleteCommandInterface $command;

    public function __construct(DeleteCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): DeleteCommandInterface
    {
        return $this->command;
    }
}
