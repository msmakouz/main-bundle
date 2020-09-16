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

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

abstract class AbstractDataTableQuery implements QueryInterface
{
    private string $table;
    private array $typeOptions;
    private array $options;

    public function __construct(string $table, array $typeOptions = [], array $options = [])
    {
        $this->table = $table;
        $this->typeOptions = $typeOptions;
        $this->options = $options;
    }

    public function getTableType(): string
    {
        return $this->table;
    }

    public function getTypeOptions(): array
    {
        return $this->typeOptions;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}