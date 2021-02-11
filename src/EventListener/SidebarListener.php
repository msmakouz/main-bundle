<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventListener;

use Zentlix\MainBundle\Domain\AdminSidebar\Event\BeforeBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Service\MenuItemInterface;

class SidebarListener
{
    public function __invoke(BeforeBuild $beforeBuild): void
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
            ->sort(10);

        $sites
            ->addChildren('zentlix_main.site.create.action')
            ->generateUrl('admin.site.create')
            ->sort(20);

        $sites
            ->addChildren('zentlix_main.template.templates')
            ->generateUrl('admin.template.list')
            ->sort(30);

        $settings = $sidebar->addMenuItem('zentlix_main.settings')
            ->url('/settings/')
            ->icon(MenuItemInterface::ICON_SETTINGS)
            ->sort(130);

        $settings
            ->addChildren('zentlix_main.attribute.attributes')
            ->generateUrl('admin.attribute.index')
            ->sort(10);

        $settings
            ->addChildren('zentlix_main.bundle.bundles')
            ->generateUrl('admin.bundle.list')
            ->sort(20);

        $settings
            ->addChildren('zentlix_main.localisation')
            ->generateUrl('admin.locale.list')
            ->sort(30);

        $sidebar->addSectionTitle('zentlix_main.tools')->sort(220);

        $marketplace = $sidebar->addMenuItem('zentlix_main.marketplace.marketplace')
            ->url('/marketplace/')
            ->icon(MenuItemInterface::ICON_APPLICATIONS)
            ->sort(330);

        $marketplace
            ->addChildren('zentlix_main.bundle.bundles')
            ->generateUrl('admin.marketplace.applications')
            ->sort(10);

        $platform = $sidebar->addMenuItem('zentlix_main.platform')
            ->url('admin.platform.about')
            ->icon(MenuItemInterface::ICON_LAYERS)
            ->sort(440);

        $platform
            ->addChildren('zentlix_main.about_system')
            ->generateUrl('admin.platform.about')
            ->sort(10);
    }
}