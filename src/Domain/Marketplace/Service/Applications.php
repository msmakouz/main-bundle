<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Marketplace\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Applications
{
    public const DEFAULT_LIMIT = 30;

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getItems(int $page, int $limit, ?string $sort = null, ?int $category = null): array
    {
        $params = [
            'query' => [
                'page'     => $page,
                'limit'    => $limit,
                'category' => $category,
                'sort'     => $sort
            ]
        ];

        return $this->client
            ->request(Request::METHOD_GET, 'https://zentlix.io/api/applications', $params)
            ->toArray();
    }
}