<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Read;

class CollectionFilter
{
    public array $id = [];

    public function __construct(array $parameters = [])
    {
        if (isset($parameters['id'])) {
            $this->id = array_map(fn ($id) => (string) $id, (array) $parameters['id']);
        }
    }
}
