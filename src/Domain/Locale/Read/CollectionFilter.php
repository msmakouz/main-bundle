<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Read;

class CollectionFilter
{
    public array $id = [];
    public array $code = [];

    public function __construct(array $parameters = [])
    {
        if (isset($parameters['id'])) {
            $this->id = array_map(fn ($id) => (string) $id, (array) $parameters['id']);
        }

        if (isset($parameters['code'])) {
            $this->code = array_map(fn ($code) => (string) $code, (array) $parameters['code']);
        }
    }
}
