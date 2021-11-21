<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\AdminSidebar\Service;

interface SidebarInterface
{
    public function getSidebar(): array;

    public function addMenuItem(string $name): MenuItemInterface;

    public function addSectionTitle(string $title, int $sort = 500): MenuItemInterface;

    public function getMenuItem(string $identifier): MenuItemInterface;

    public function findMenuItem(string $identifier): ?MenuItemInterface;

    public function build(): array;
}
