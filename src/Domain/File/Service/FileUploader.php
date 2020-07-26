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

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Domain\File\Entity\File;

class FileUploader implements FileUploaderInterface
{
    private string $uploadDirectory;
    private EntityManagerInterface $entityManager;

    public function __construct(string $uploadDirectory, EntityManagerInterface $entityManager)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->entityManager = $entityManager;
    }

    public function upload(UploadCommand $command): File
    {
        $file = $command->uploadedFile->move($this->uploadDirectory . DIRECTORY_SEPARATOR . $command->savePath, $command->filename);

        $entity = new File($file->getPathname());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function remove(File $file = null): void
    {
        if(is_null($file)) {
            return;
        }

        if(is_file($file->getAbsolutePath())) {
            unlink($file->getAbsolutePath());
        }

        $this->entityManager->remove($file);
        $this->entityManager->flush();
    }

    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }
}