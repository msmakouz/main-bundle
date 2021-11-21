<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Event;

final class AfterRemove
{
    private string $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
