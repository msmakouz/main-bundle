<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\File;

use Symfony\Component\HttpFoundation\File\File;
use Zentlix\MainBundle\Domain\File\Repository\FileRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetFileByPathHandler implements QueryHandlerInterface
{
    public function __construct(
        private FileRepository $fileRepository
    ) {
    }

    public function __invoke(GetFileByPathQuery $getFileByPathQuery): array
    {
        $entity = $this->fileRepository->getOneByPath($getFileByPathQuery->path);
        $file = new File($entity->getAbsolutePath());

        return [
            'id' => $entity->getId(),
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
