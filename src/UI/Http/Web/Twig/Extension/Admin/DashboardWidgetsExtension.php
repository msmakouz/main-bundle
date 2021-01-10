<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension\Admin;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Dashboard\Service\Widgets;
use Zentlix\MainBundle\Infrastructure\Dashboard\Widget\WidgetInterface;
use Zentlix\UserBundle\Domain\Admin\Service\AdminSettings;

final class DashboardWidgetsExtension extends AbstractExtension
{
    private AdminSettings $settings;
    private Widgets $widgets;

    public function __construct(AdminSettings $settings, Widgets $widgets)
    {
        $this->settings = $settings;
        $this->widgets = $widgets;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('admin_dashboard_widgets', [$this, 'getWidgets'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    public function getWidgets(Environment $twig): string
    {
        $widgets = '';
        foreach ($this->settings->getWidgets() as $widget => $visible) {
            /** @var WidgetInterface $widgetObj */
            foreach ($this->widgets->getWidgets() as $widgetObj) {
                $reflection = new \ReflectionClass($widgetObj);
                if($widget === $reflection->getName() && $visible) {
                    $widgets .= $twig->render($widgetObj->getTemplate(), ['widget' => $widgetObj]);
                }
            }
        }

        return $widgets;
    }
}