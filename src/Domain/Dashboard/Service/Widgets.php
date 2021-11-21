<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard\Service;

use Zentlix\MainBundle\Infrastructure\Dashboard\Widget\WidgetInterface;

class Widgets
{
    private array $widgets = [];

    public function __construct(iterable $widgets)
    {
        foreach ($widgets as $widget) {
            $this->addWidget($widget);
        }
    }

    public function addWidget(WidgetInterface $widget): void
    {
        $this->widgets[get_class($widget)] = $widget;
    }

    public function getWidgets(): array
    {
        return $this->widgets;
    }

    public function get(string $class): WidgetInterface
    {
        if (isset($this->widgets[$class])) {
            return $this->widgets[$class];
        }

        throw new \DomainException(sprintf('Widget %s not found.', $class));
    }

    public function find(string $class): ?WidgetInterface
    {
        if (isset($this->widgets[$class])) {
            return $this->widgets[$class];
        }

        return null;
    }
}
