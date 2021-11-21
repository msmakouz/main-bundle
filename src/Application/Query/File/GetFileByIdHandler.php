<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\File;

use Symfony\Component\HttpFoundation\File\File;
use Zentlix\MainBundle\Domain\File\Repository\FileRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetFileByIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private FileRepository $fileRepository
    ) {
    }

    public function __invoke(GetFileByIdQuery $getFileByIdQuery): array
    {
        $entity = $this->fileRepository->get($getFileByIdQuery->id);
        $file = new File($entity->getAbsolutePath());

        return [
            'id' => $getFileByIdQuery->id,
            'name' => $file->getFilename(),
            'url' => $entity->getPath(),
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'extension' => $file->getExtension(),
            'title' => $entity->getTitle(),
            'alt' => $entity->getAlt(),
            'success' => true,
        ];
    }
}
