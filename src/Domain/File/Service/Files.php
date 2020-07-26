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

use Zentlix\MainBundle\Domain\File\Repository\FileRepository;

class Files
{
    private FileRepository $fileRepository;
    private FileUploaderInterface $fileUploader;

    public function __construct(FileRepository $fileRepository, FileUploaderInterface $fileUploader)
    {
        $this->fileRepository = $fileRepository;
        $this->fileUploader = $fileUploader;
    }

    public function CleaningGarbage()
    {
        $files = $this->fileRepository->findDeleted();

        foreach ($files as $file) {
            $this->fileUploader->remove($file);
        }
    }
}