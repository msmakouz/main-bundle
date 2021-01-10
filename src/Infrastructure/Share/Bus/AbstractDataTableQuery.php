<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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