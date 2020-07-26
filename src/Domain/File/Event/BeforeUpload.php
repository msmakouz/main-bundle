<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Event;

use Zentlix\MainBundle\Application\Command\File\UploadCommand;

final class BeforeUpload
{
    private $command;

    public function __construct(UploadCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UploadCommand
    {
        return $this->command;
    }
}