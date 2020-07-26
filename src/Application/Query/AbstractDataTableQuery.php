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

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function getTableType(): string
    {
        return $this->table;
    }
}