<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Zentlix\MainBundle\Application\Command\CreateCommandInterface;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;

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