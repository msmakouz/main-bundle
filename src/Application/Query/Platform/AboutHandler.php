<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Platform;

use Doctrine\DBAL\Connection;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class AboutHandler implements QueryHandlerInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function __invoke(AboutQuery $query): array
    {
        return [
            'php_version' => phpversion(),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'database_server_version' => $this->connection->getWrappedConnection()->getServerVersion(),
        ];
    }
}
