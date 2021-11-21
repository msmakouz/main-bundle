<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CreateCommandInterface;

class AbstractAfterCreate
{
    private Eventable $entity;
    private CreateCommandInterface $command;

    public function __construct(Eventable $entity, CreateCommandInterface $command)
    {
        $this->entity = $entity;
        $this->command = $command;
    }

    public function getEntity(): Eventable
    {
        return $this->entity;
    }

    public function getCommand(): CreateCommandInterface
    {
        return $this->command;
    }
}
