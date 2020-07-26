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

use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class UniqueFilenameSpecification extends AbstractSpecification
{
    public function isUnique(string $filename, string $path): bool
    {
        return $this->isSatisfiedBy([$filename, $path]);
    }

    public function isSatisfiedBy($value): bool
    {
        if(file_exists($value[1] . $value[0])) {
            return false;
        }

        return true;
    }

    public function __invoke(string $filename, string $path)
    {
        return $this->isUnique($filename, $path);
    }
}