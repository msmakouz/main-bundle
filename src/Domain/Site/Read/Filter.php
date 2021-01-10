<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Read;

class Filter
{
    public function __construct(array $parameters)
    {
        $this->id  = isset($parameters['id']) ? (int) $parameters['id'] : null;
        $this->url = isset($parameters['url']) ? (string) $parameters['url'] : null;
    }

    public ?int $id;
    public ?string $url;
}