<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Read;

class Filter
{
    public ?string $id;
    public ?string $url;

    public function __construct(array $parameters)
    {
        $this->id = isset($parameters['id']) ? (string) $parameters['id'] : null;
        $this->url = isset($parameters['url']) ? (string) $parameters['url'] : null;
    }
}
