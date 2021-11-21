<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\AdminSidebar\Event;

use Zentlix\MainBundle\Domain\AdminSidebar\Service\SidebarInterface;

final class BeforeBuild
{
    public function __construct(
        private SidebarInterface $sidebar
    ) {
    }

    public function getSidebar(): SidebarInterface
    {
        return $this->sidebar;
    }
}
