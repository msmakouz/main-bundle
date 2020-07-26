<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zentlix\MainBundle\Domain\AdminSidebar\Event\BeforeBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Service\MenuItemInterface;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;

class MainSubscriber implements EventSubscriberInterface
{
    private array $sites;

    public function __construct(SiteRepository $sites)
    {
        $this->sites = $sites->findAll();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeBuild::class => 'sidebar',
        ];
    }

    public function sidebar(BeforeBuild $beforeBuild): void
    {
        $sidebar = $beforeBuild->getSidebar();

        $sidebar
            ->addMenuItem('zentlix_main.control_panel')
            ->generateUrl('admin.index')
            ->icon(MenuItemInterface::ICON_SPEEDOMETER)
            ->sort(100);

        $sidebar->addSectionTitle('zentlix_main.site.control')->sort(110);

        $sites = $sidebar->addMenuItem('zentlix_main.site.sites')
            ->url('/sites/')
            ->icon(MenuItemInterface::ICON_LAYERS)
            ->sort(120);

        $sites
            ->addChildren('zentlix_main.site.in_system')
            ->generateUrl('admin.site.list')
            ->sort(100);

        $sites
            ->addChildren('zentlix_main.site.create.action')
            ->generateUrl('admin.site.create')
            ->sort(110);

        $settings = $sidebar->addMenuItem('zentlix_main.settings')
            ->url('/settings/')
            ->icon(MenuItemInterface::ICON_SETTINGS)
            ->sort(130);

        $settings
            ->addChildren('zentlix_main.bundle.bundles')
            ->generateUrl('admin.bundle.list')
            ->sort(120);

        $settings
            ->addChildren('zentlix_main.route.routes')
            ->generateUrl('admin.routes.update')
            ->sort(130);

        $settings
            ->addChildren('zentlix_main.localisation')
            ->generateUrl('admin.locale.list')
            ->sort(140);

        $sidebar->addSectionTitle('zentlix_main.tools')->sort(220);

        $platform = $sidebar->addMenuItem('zentlix_main.platform')
            ->url('admin.platform.about')
            ->icon(MenuItemInterface::ICON_LAYERS)
            ->sort(230);

        $platform
            ->addChildren('zentlix_main.about_system')
            ->generateUrl('admin.platform.about')
            ->sort(130);
    }
}