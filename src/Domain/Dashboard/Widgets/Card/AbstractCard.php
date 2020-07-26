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

use Zentlix\MainBundle\Domain\Dashboard\WidgetInterface;

abstract class AbstractCard implements WidgetInterface
{
    public function getBackgroundColor(): string
    {
        return self::BACKGROUND_COLOR_WHITE;
    }

    public function getBackgroundGradient(): string
    {
        return $this->getBackgroundColor();
    }

    public function getColor(): string
    {
        return '#3c4b64';
    }

    public function getHelpTextColor(): string
    {
        return '#768192';
    }

    public abstract function getData();
    public abstract function getValue();
    public abstract function getText();
    public abstract function getHelpText();

    public const BACKGROUND_COLOR_WHITE = '#ffffff';
    public const BACKGROUND_COLOR_BlUE = '#1f1498';
    public const BACKGROUND_COLOR_LIGHT_BlUE = '#2982cc';
    public const BACKGROUND_COLOR_ORANGE = '#f6960b';
    public const BACKGROUND_COLOR_RED = '#d93737';

    public const BACKGROUND_BlUE_GRADIENT = 'linear-gradient(45deg,#321fdb 0%,#1f1498 100%)';
    public const BACKGROUND_LIGHT_BlUE_GRADIENT = 'linear-gradient(45deg,#39f 0%,#2982cc 100%)';
    public const BACKGROUND_ORANGE_GRADIENT = 'linear-gradient(45deg,#f9b115 0%,#f6960b 100%)';
    public const BACKGROUND_RED_GRADIENT = 'linear-gradient(45deg,#e55353 0%,#d93737 100%)';
}