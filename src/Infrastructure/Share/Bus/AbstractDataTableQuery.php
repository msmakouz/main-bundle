<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

abstract class AbstractDataTableQuery implements QueryInterface
{
    public string $table;
    public array $typeOptions;
    public array $options;

    public function __construct(string $table, array $typeOptions = [], array $options = [])
    {
        $this->table = $table;
        $this->typeOptions = $typeOptions;
        $this->options = $options;
    }
}
