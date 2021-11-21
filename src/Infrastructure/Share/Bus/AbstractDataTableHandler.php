<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

use Zentlix\MainBundle\Domain\DataTable\Service\DataTableService;

abstract class AbstractDataTableHandler implements QueryHandlerInterface
{
    private DataTableService $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }

    public function __invoke(AbstractDataTableQuery $dataTableQuery)
    {
        return $this->dataTableService->createDataTableFromType(
            $dataTableQuery->table,
            $dataTableQuery->typeOptions,
            $dataTableQuery->options
        );
    }
}
