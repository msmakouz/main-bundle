<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard\Service;

use Zentlix\MainBundle\Domain\Dashboard\WidgetInterface;

class Widgets
{
    private array $widgets = [];

    public function __construct(iterable $widgets)
    {
        foreach ($widgets as $widget) {
            $this->addWidget($widget);
        }
    }

    public function addWidget(WidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    public function getWidgets(): array
    {
        return $this->widgets;
    }
}