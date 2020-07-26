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

class MenuItem implements MenuItemInterface
{
    private UrlGeneratorInterface $router;
    private string $identifier;
    private ?string $name = null;
    private ?string $icon = null;
    private ?string $url = null;
    private int $sort = 500;
    private array $children = [];
    private bool $title = false;

    public function __construct(string $identifier, $name, UrlGeneratorInterface $router)
    {
        $this->router = $router;
        $this->identifier = $identifier;
        $this->name = $name;
    }

    public static function createTitle(string $title, int $sort, UrlGeneratorInterface $router): self
    {
        $self = new self(md5($title), $title, $router);

        return $self->sort($sort)->setTitle(true);
    }

    private function setTitle(bool $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isTitle(): bool
    {
        return $this->title;
    }

    public function sort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function generateUrl(string $routeName): self
    {
        $this->url = str_replace('/backend', '', $this->router->generate($routeName));

        return $this;
    }

    public function addChildren(string $name): self
    {
        $identifier = md5($name);
        if(isset($this->children[$identifier])) {
            $identifier = md5($name . uniqid('', true));
        }

        $this->children[$identifier] = new MenuItem($identifier, $name, $this->router);

        return $this->children[$identifier];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getChildren(): ?array
    {
        if(count($this->children) > 0) {
            return array_values($this->children);
        }

        return null;
    }

    public function getMenuItem(string $identifier): self
    {
        if(!isset($this->children[$identifier])) {
            throw new \Exception(sprintf('Menu item %s not found.', $identifier));
        }

        return $this->children[$identifier];
    }

    public function sortChildrens(): void
    {
        uasort($this->children, [$this, 'sortChilds']);
    }

    private function sortChilds(MenuItemInterface $a, MenuItemInterface $b)
    {
        $a->sortChildrens();
        $b->sortChildrens();

        return ($a->getSort() - $b->getSort());
    }
}