<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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