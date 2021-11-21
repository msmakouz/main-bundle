<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Read;

class Filter
{
    public ?string $id;

    public function __construct(array $parameters)
    {
        $this->id = isset($parameters['id']) ? (int) $parameters['id'] : null;
    }
}
