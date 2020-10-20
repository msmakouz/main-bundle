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

interface MenuItemInterface
{
    public static function createTitle(string $title, int $sort, UrlGeneratorInterface $router): MenuItemInterface;
    public function isTitle(): bool;
    public function sort(int $sort): self;
    public function icon(string $icon): self;
    public function url(string $url): self;
    public function generateUrl(string $routeName, array $parameters = []): self;
    public function addChildren(string $name): self;
    public function getName(): ?string;
    public function getUrl(): ?string;
    public function getIcon(): ?string;
    public function getSort(): int;
    public function getChildren(): ?array;
    public function getMenuItem(string $identifier): self;

    public const ICON_DESCRIPTION = 'cil-description';
    public const ICON_SPEEDOMETER = 'cil-speedometer';
    public const ICON_LAYERS = 'cil-layers';
    public const ICON_SETTINGS = 'cil-settings';
    public const ICON_PEOPLE = 'cil-people';
    public const ICON_BASKET = 'cil-basket';
    public const ICON_WALLET = 'cil-wallet';
    public const ICON_LIBRARY_ADD = 'cil-library-add';
    public const ICON_NOTE = 'cil-notes';
    public const ICON_PLUS = 'cil-plus';
    public const ICON_CLOUD_UPLOAD = 'cil-cloud-upload';
}