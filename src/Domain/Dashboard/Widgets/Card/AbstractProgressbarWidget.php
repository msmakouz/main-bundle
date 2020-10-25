<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard\Widgets\Card;

use Zentlix\MainBundle\Infrastructure\Dashboard\Widget\WidgetInterface;

abstract class AbstractProgressbarWidget implements WidgetInterface
{
    abstract public function getProgressbarPercent(): float;
    abstract public function getValue();
    abstract public function getTitle(): string;
    abstract public function getText(): string;
    abstract public function getHelpText(): string;

    public function getBackgroundGradient(): string
    {
        return static::GRADIENT_BLUE;
    }

    public function getProgressbarBackgroundGradient(): string
    {
        return '';
    }

    public function getColor(): string
    {
        return '#fff';
    }

    public function getHelpTextColor(): string
    {
        return 'rgba(255,255,255,.6) !important;';
    }

    public function getTemplate(): string
    {
        return '@MainBundle/admin/widgets/dashboard/progressbar_card.html.twig';
    }

    public const GRADIENT_BLUE = 'bg-gradient-primary';
    public const GRADIENT_LIGHT_BLUE = 'bg-gradient-info';
    public const GRADIENT_ORANGE = 'bg-gradient-warning';
    public const GRADIENT_RED = 'bg-gradient-danger';
    public const GRADIENT_GREEN = 'bg-gradient-success';
}