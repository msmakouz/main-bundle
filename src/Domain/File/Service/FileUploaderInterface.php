<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Service;

use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Domain\File\Entity\File;

interface FileUploaderInterface
{
    public function upload(UploadCommand $command): File;

    public function remove(File $file): void;

    public function getUploadDirectory(): string;
}
