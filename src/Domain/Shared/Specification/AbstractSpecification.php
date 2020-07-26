<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Specification;

abstract class AbstractSpecification
{
    abstract public function isSatisfiedBy($value): bool;

    final public function not($value): bool
    {
        return !$this->isSatisfiedBy($value);
    }
}