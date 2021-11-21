<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Read;

class CollectionFilter
{
    public array $id = [];
    public array $url = [];

    public function __construct(array $parameters = [])
    {
        if (isset($parameters['id'])) {
            $this->id = array_map(fn ($id) => (string) $id, (array) $parameters['id']);
        }

        if (isset($parameters['url'])) {
            $this->url = array_map(fn ($url) => (string) $url, (array) $parameters['url']);
        }
    }
}
