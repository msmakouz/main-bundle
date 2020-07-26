<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\AdminSidebar\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Sidebar implements SidebarInterface
{
    private UrlGeneratorInterface $router;
    private array $sidebar = [];

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function getSidebar(): array
    {
        return $this->sidebar;
    }

    public function addMenuItem(string $name): MenuItemInterface
    {
        $identifier = md5($name);

        if(isset($this->sidebar[$identifier])) {
            $identifier = md5($name . uniqid('', true));
        }

        $this->sidebar[$identifier] = new MenuItem($identifier, $name, $this->router);

        return $this->sidebar[$identifier];
    }

    public function addSectionTitle(string $title, int $sort = 500): MenuItemInterface
    {
        $this->sidebar[md5($title)] = MenuItem::createTitle($title, $sort, $this->router);

        return $this->sidebar[md5($title)];
    }

    public function getMenuItem(string $identifier): MenuItemInterface
    {
        if(isset($this->sidebar[$identifier])) {
            return $this->sidebar[$identifier];
        }
        $identifier = md5($identifier);

        if(!isset($this->sidebar[$identifier])) {
            throw new \Exception(sprintf('Menu item %s not found.', $identifier));
        }

        return $this->sidebar[$identifier];
    }

    public function build(): array
    {
        $sidebar = $this->sidebar;

        uasort($sidebar, function(MenuItemInterface $a, MenuItemInterface $b) {
            return ($a->getSort() - $b->getSort());
        });

        /** @var MenuItemInterface $menuItem */
        foreach ($this->sidebar as $menuItem) {
            $menuItem->sortChildrens();
        }

        return array_values($sidebar);
    }
}