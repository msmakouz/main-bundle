<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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