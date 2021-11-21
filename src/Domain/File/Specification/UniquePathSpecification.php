<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Specification;

use Zentlix\MainBundle\Domain\File\Repository\FileRepository;

final class UniquePathSpecification
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(string $path): bool
    {
        return $this->isUnique($path);
    }

    public function isUnique(string $path): bool
    {
        if ($this->fileRepository->findOneByPath($path)) {
            return false;
        }

        return true;
    }
}
