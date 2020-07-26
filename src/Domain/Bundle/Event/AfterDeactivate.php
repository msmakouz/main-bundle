<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Event;

final class AfterDeactivate
{
    private string $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function getClass() :string 
    {
        return $this->class;
    }
}