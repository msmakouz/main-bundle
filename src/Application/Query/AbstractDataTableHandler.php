<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query;

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
            $dataTableQuery->getTableType(),
            $dataTableQuery->getTypeOptions(),
            $dataTableQuery->getOptions()
        );
    }
}