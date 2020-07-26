<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Specification;

use Zentlix\MainBundle\Domain\File\Repository\FileRepository;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class UniquePathSpecification extends AbstractSpecification
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function isUnique(string $path): bool
    {
        return $this->isSatisfiedBy($path);
    }

    public function isSatisfiedBy($value): bool
    {
        if($this->fileRepository->findOneByPath($value)) {
            return false;
        }

        return true;
    }

    public function __invoke(string $path)
    {
        return $this->isUnique($path);
    }
}