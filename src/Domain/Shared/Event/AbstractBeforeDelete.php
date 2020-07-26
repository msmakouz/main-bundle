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

use Zentlix\MainBundle\Application\Command\DeleteCommandInterface;

class AbstractBeforeDelete
{
    private DeleteCommandInterface $command;

    public function __construct(DeleteCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand() :DeleteCommandInterface
    {
        return $this->command;
    }
}