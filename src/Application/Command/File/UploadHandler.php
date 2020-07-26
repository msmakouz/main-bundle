<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\File;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\File\Event\BeforeUpload;
use Zentlix\MainBundle\Domain\File\Event\AfterUpload;
use Zentlix\MainBundle\Domain\File\Service\FileUploaderInterface;
use Zentlix\MainBundle\Domain\File\Specification\UniqueFilenameSpecification;
use Zentlix\MainBundle\Domain\File\Specification\UniquePathSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Doctrine\Uuid;

class UploadHandler implements CommandHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private FileUploaderInterface $fileUploader;
    private UniqueFilenameSpecification $uniqueFilenameSpecification;
    private UniquePathSpecification $uniquePathSpecification;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                FileUploaderInterface $fileUploader,
                                UniqueFilenameSpecification $uniqueFilenameSpecification,
                                UniquePathSpecification $uniquePathSpecification)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->fileUploader = $fileUploader;
        $this->uniqueFilenameSpecification = $uniqueFilenameSpecification;
        $this->uniquePathSpecification = $uniquePathSpecification;
    }

    public function __invoke(UploadCommand $command): void
    {
        $path = $this->fileUploader->getUploadDirectory() . DIRECTORY_SEPARATOR . $command->savePath;

        if($this->uniqueFilenameSpecification->isUnique($command->filename, $path) === false) {
            $command->filename = Uuid::uuid4() . '.' . $command->uploadedFile->getClientOriginalExtension();
        }

        if($this->uniquePathSpecification->isUnique($path . DIRECTORY_SEPARATOR . $command->filename) === false) {
            $command->filename = Uuid::uuid4() . '.' . $command->uploadedFile->getClientOriginalExtension();
        }

        $this->eventDispatcher->dispatch(new BeforeUpload($command));

        $uploadedFile = $this->fileUploader->upload($command);

        $command->id = $uploadedFile->getId();

        $this->eventDispatcher->dispatch(new AfterUpload($uploadedFile));
    }
}