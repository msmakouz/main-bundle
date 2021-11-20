<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\File;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Domain\File\Event\BeforeUpload;
use Zentlix\MainBundle\Domain\File\Event\AfterUpload;
use Zentlix\MainBundle\Domain\File\Service\FileUploaderInterface;
use Zentlix\MainBundle\Domain\File\Specification\UniquePathSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class UploadHandler implements CommandHandlerInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private FileUploaderInterface $fileUploader,
        private UniquePathSpecification $uniquePathSpecification
    ) {
    }

    public function __invoke(UploadCommand $command): void
    {
        $path = $this->fileUploader->getUploadDirectory() . '/' . $command->savePath;
        if($path[0] !== '/') {
            $path = '/' . $path;
        }

        if($this->uniquePathSpecification->isUnique($path . '/' . $command->filename) === false) {
            $command->filename = Uuid::v4() . '.' . $command->uploadedFile->getClientOriginalExtension();
        }

        $this->eventDispatcher->dispatch(new BeforeUpload($command));

        $uploadedFile = $this->fileUploader->upload($command);

        $command->id = $uploadedFile->getId();

        $this->eventDispatcher->dispatch(new AfterUpload($uploadedFile));
    }
}