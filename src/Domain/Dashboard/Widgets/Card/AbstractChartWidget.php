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

abstract class AbstractChartWidget extends AbstractCard
{
    public function getType(): string
    {
        return self::TYPE_CARD_CHART;
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
        ];
    }

    public const TYPE_CARD_CHART = 'card-chart';
}