<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard\Widgets;

use Zentlix\MainBundle\Infrastructure\Dashboard\Widget\WidgetInterface;

abstract class AbstractTableWidget implements WidgetInterface
{
    abstract public function getHeaders(): array;

    abstract public function getRows(): array;

    public function getTemplate(): string
    {
        return '@MainBundle/admin/widgets/dashboard/table.html.twig';
    }
}
