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

class CollectionFilter
{
    public function __construct(array $parameters = [])
    {
        if(isset($parameters['id'])) {
            $this->id = array_map(fn($id) => (int) $id, (array) $parameters['id']);
        }

        if(isset($parameters['url'])) {
            $this->url = array_map(fn($url) => (string) $url, (array) $parameters['url']);
        }
    }

    public array $id = [];
    public array $url = [];
}