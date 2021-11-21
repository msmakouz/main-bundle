<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Omines\DataTablesBundle\DataTable;

class AbstractDataTableBuilder
{
    private DataTable $dataTableBuilder;

    public function __construct(DataTable $dataTableBuilder)
    {
        $this->dataTableBuilder = $dataTableBuilder;
    }

    public function getDataTableBuilder(): DataTable
    {
        return $this->dataTableBuilder;
    }
}
