<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DashboardWidget;

use Zentlix\MainBundle\Domain\Dashboard\Widgets\Card\AbstractProgressbarWidget;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;

class SitesCount extends AbstractProgressbarWidget
{
    private SiteRepository $siteRepository;

    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    public function getTitle(): string
    {
        return 'zentlix_main.widgets.count_sites';
    }

    public function getText(): string
    {
        return 'zentlix_main.widgets.sites';
    }

    public function getHelpText(): string
    {
        return 'zentlix_main.widgets.sites_help';
    }

    public function getProgressbarPercent(): float
    {
        return 100;
    }

    public function getValue()
    {
        return $this->siteRepository->count([]);
    }

    public function getBackgroundGradient(): string
    {
        return self::GRADIENT_BLUE;
    }
}
