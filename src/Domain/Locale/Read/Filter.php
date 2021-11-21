<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Read;

class Filter
{
    public ?string $id;
    public ?string $code;

    public function __construct(array $parameters)
    {
        $this->id = isset($parameters['id']) ? (string) $parameters['id'] : null;
        $this->code = isset($parameters['code']) ? (string) $parameters['code'] : null;
    }
}
