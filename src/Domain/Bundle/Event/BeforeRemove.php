<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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