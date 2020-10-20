<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Platform;

use Doctrine\DBAL\Connection;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class AboutQueryHandler implements QueryHandlerInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(AboutQuery $query): array
    {
        return [
            'php_version'             => phpversion(),
            'max_execution_time'      => ini_get('max_execution_time'),
            'memory_limit'            => ini_get('memory_limit'),
            'database_server_version' => $this->connection->getWrappedConnection()->getServerVersion(),
        ];
    }
}