<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Widget;

use Zentlix\MainBundle\Application\Query\QueryHandlerInterface;
use Zentlix\MainBundle\Domain\Dashboard\Service\Widgets;
use Zentlix\MainBundle\Domain\Dashboard\WidgetInterface;
use Zentlix\UserBundle\Domain\Admin\Service\AdminSettings;

class WidgetsQueryHandler implements QueryHandlerInterface
{
    private Widgets $widgets;
    private AdminSettings $settings;

    public function __construct(Widgets $widgets, AdminSettings $settings)
    {
        $this->widgets = $widgets;
        $this->settings = $settings;
    }

    public function __invoke(WidgetsQuery $query): array
    {
        $widgets = [];
        foreach ($this->settings->getWidgets() as $widget => $visible) {
            /** @var WidgetInterface $widgetObj */
            foreach ($this->widgets->getWidgets() as $widgetObj) {
                $reflection = new \ReflectionClass($widgetObj);
                if($widget === $reflection->getName() && $visible === true) {
                    $widgets[] = $widgetObj->getData();
                }
            }
        }

        return [
            'widgets' => $widgets
        ];
    }
}