<?php

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
        if (!isset($this->{$name})) {
            $this->createProperty($name, null);
        }

        return $this->{$name};
    }
}
