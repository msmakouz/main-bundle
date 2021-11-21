<?php

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
                'page' => $page,
                'limit' => $limit,
                'category' => $category,
                'sort' => $sort,
            ],
        ];

        return $this->client
            ->request(Request::METHOD_GET, 'https://zentlix.io/api/applications', $params)
            ->toArray();
    }
}
