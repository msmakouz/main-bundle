<?php

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

    public function cleaningGarbage(): void
    {
        $files = $this->fileRepository->findDeleted();

        foreach ($files as $file) {
            $this->fileUploader->remove($file);
        }
    }
}
