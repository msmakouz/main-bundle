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

abstract class AbstractProgressbarWidget extends AbstractCard
{
    public function getType(): string
    {
        return self::TYPE_CARD_PROGRESSBAR;
    }

    public function getProgressbarPercent(): float
    {
        return 0;
    }

    public function getProgressbarBackgroundColor(): string
    {
        return self::PROGRESSBAR_BACKGROUND_COLOR_GREEN;
    }

    public function getProgressbarBackgroundGradient(): string
    {
        return self::PROGRESSBAR_BACKGROUND_GRADIENT_GREEN;
    }

    public function getData()
    {
        return [
            'type'                          => $this->getType(),
            'value'                         => $this->getValue(),
            'text'                          => $this->getText(),
            'helpText'                      => $this->getHelpText(),
            'backgroundColor'               => $this->getBackgroundColor(),
            'backgroundGradient'            => $this->getBackgroundGradient(),
            'color'                         => $this->getColor(),
            'helpTextColor'                 => $this->getHelpTextColor(),
            'progressbarPercent'            => $this->getProgressbarPercent(),
            'progressbarBackgroundColor'    => $this->getProgressbarBackgroundColor(),
            'progressbarBackgroundGradient' => $this->getProgressbarBackgroundGradient(),
        ];
    }

    public const PROGRESSBAR_BACKGROUND_COLOR_WHITE = '#fff';
    public const PROGRESSBAR_BACKGROUND_COLOR_GREEN = '#1b9e3e';
    public const PROGRESSBAR_BACKGROUND_COLOR_BLUE = '#2982cc';
    public const PROGRESSBAR_BACKGROUND_COLOR_ORANGE = '#f6960b';
    public const PROGRESSBAR_BACKGROUND_COLOR_RED = '#d93737';

    public const PROGRESSBAR_BACKGROUND_GRADIENT_GREEN = 'linear-gradient(45deg,#2eb85c 0%,#1b9e3e 100%)';
    public const PROGRESSBAR_BACKGROUND_GRADIENT_BLUE = 'linear-gradient(45deg,#39f 0%,#2982cc 100%)';
    public const PROGRESSBAR_BACKGROUND_GRADIENT_ORANGE = 'linear-gradient(45deg,#f9b115 0%,#f6960b 100%)';
    public const PROGRESSBAR_BACKGROUND_GRADIENT_RED = 'linear-gradient(45deg,#e55353 0%,#d93737 100%)';

    public const TYPE_CARD_PROGRESSBAR = 'card-progressbar';
}