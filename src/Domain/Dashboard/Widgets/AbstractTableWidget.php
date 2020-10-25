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

use Zentlix\MainBundle\Infrastructure\Dashboard\Widget\WidgetInterface;

abstract class AbstractTableWidget implements WidgetInterface
{
    abstract function getHeaders(): array;
    abstract function getRows(): array;

    public function getTemplate(): string
    {
        return '@MainBundle/admin/widgets/dashboard/table.html.twig';
    }
}