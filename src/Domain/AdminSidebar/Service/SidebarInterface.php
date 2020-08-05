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

interface SidebarInterface
{
    public function getSidebar(): array;
    public function addMenuItem(string $name): MenuItemInterface;
    public function addSectionTitle(string $title, int $sort = 500): MenuItemInterface;
    public function getMenuItem(string $identifier): MenuItemInterface;
    public function findMenuItem(string $identifier): ?MenuItemInterface;
    public function build(): array;
}