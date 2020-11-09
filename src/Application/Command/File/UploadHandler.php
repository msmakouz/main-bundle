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
use Zentlix\MainBundle\Domain\File\Event\BeforeUpload;
use Zentlix\MainBundle\Domain\File\Event\AfterUpload;
use Zentlix\MainBundle\Domain\File\Service\FileUploaderInterface;
use Zentlix\MainBundle\Domain\File\Specification\UniquePathSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;
use Zentlix\MainBundle\Infrastructure\Share\Doctrine\Uuid;

class UploadHandler implements CommandHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private FileUploaderInterface $fileUploader;
    private UniquePathSpecification $uniquePathSpecification;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                FileUploaderInterface $fileUploader,
                                UniquePathSpecification $uniquePathSpecification)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->fileUploader = $fileUploader;
        $this->uniquePathSpecification = $uniquePathSpecification;
    }

    public function __invoke(UploadCommand $command): void
    {
        $path = $this->fileUploader->getUploadDirectory() . '/' . $command->savePath;
        if($path[0] !== '/') {
            $path = '/' . $path;
        }

        if($this->uniquePathSpecification->isUnique($path . '/' . $command->filename) === false) {
            $command->filename = Uuid::uuid4() . '.' . $command->uploadedFile->getClientOriginalExtension();
        }

        $this->eventDispatcher->dispatch(new BeforeUpload($command));

        $uploadedFile = $this->fileUploader->upload($command);

        $command->id = $uploadedFile->getId();

        $this->eventDispatcher->dispatch(new AfterUpload($uploadedFile));
    }
}