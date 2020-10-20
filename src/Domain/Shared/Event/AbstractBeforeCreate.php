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