<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Service;

class DataTableService
{
    private DataTableFactory $factory;

    public function __construct(DataTableFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createDataTable(array $options = []): DataTable
    {
        return $this->factory->create($options);
    }

    public function createDataTableFromType(string $type, array $typeOptions = [], array $options = []): DataTable
    {
        return $this->factory->createFromType($type, $typeOptions, $options);
    }
}
