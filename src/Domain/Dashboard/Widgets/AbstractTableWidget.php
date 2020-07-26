<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard\Widgets;

use Zentlix\MainBundle\Domain\Dashboard\WidgetInterface;

abstract class AbstractTableWidget implements WidgetInterface
{
    public function getType(): string
    {
        return self::TYPE_TABLE;
    }

    public function getData()
    {
        return [
            'type'    => $this->getType(),
            'title'   => $this->getTitle(),
            'headers' => $this->getHeaders(),
            'data'    => $this->getRows()
        ];
    }

    abstract function getHeaders(): array;
    abstract function getRows(): array;

    public const TYPE_TABLE = 'table';
}