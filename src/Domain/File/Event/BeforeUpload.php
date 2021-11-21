<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Event;

use Zentlix\MainBundle\Application\Command\File\UploadCommand;

final class BeforeUpload
{
    private UploadCommand $command;

    public function __construct(UploadCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UploadCommand
    {
        return $this->command;
    }
}
