<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\File;

use Symfony\Component\HttpFoundation\File\File;
use Zentlix\MainBundle\Domain\File\Repository\FileRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetFileByIdHandler implements QueryHandlerInterface
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(GetFileByIdQuery $getFileByIdQuery): array
    {
        $entity = $this->fileRepository->get($getFileByIdQuery->id);
        $file = new File($entity->getAbsolutePath());

        return [
            'id'        => $getFileByIdQuery->id,
            'name'      => $file->getFilename(),
            'url'       => $entity->getPath(),
            'mime'      => $file->getMimeType(),
            'size'      => $file->getSize(),
            'extension' => $file->getExtension(),
            'title'     => $entity->getTitle(),
            'alt'       => $entity->getAlt(),
            'success'   => true
        ];
    }
}