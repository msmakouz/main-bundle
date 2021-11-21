<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;

class AbstractAfterUpdate
{
    private Eventable $entity;
    private UpdateCommandInterface $command;

    public function __construct(Eventable $entity, UpdateCommandInterface $command)
    {
        $this->entity = $entity;
        $this->command = $command;
    }

    public function getEntity(): Eventable
    {
        return $this->entity;
    }

    public function getCommand(): UpdateCommandInterface
    {
        return $this->command;
    }
}
