<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

class DynamicPropertyCommand
{
    public function createProperty($name, $value): void
    {
        $this->{$name} = $value;
    }

    public function getProperty($name)
    {
        if(!isset($this->{$name})) {
            $this->createProperty($name, null);
        }

        return $this->{$name};
    }
}