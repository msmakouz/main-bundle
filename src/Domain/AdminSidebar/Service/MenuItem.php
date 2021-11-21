<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\AdminSidebar\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MenuItem implements MenuItemInterface
{
    private UrlGeneratorInterface $router;
    private ?string $name = null;
    private ?string $icon = null;
    private ?string $url = null;
    private int $sort = 500;
    private array $children = [];
    private bool $title = false;

    public function __construct($name, UrlGeneratorInterface $router)
    {
        $this->router = $router;
        $this->name = $name;
    }

    public static function createTitle(string $title, int $sort, UrlGeneratorInterface $router): self
    {
        $self = new self($title, $router);

        return $self->sort($sort)->setTitle(true);
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

    public function generateUrl(string $routeName, array $parameters = []): self
    {
        $this->url = $this->router->generate($routeName, $parameters);

        return $this;
    }

    public function addChildren(string $name): self
    {
        $identifier = md5($name);
        if (isset($this->children[$identifier])) {
            $identifier = md5($name . uniqid('', true));
        }

        $this->children[$identifier] = new MenuItem($name, $this->router);

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
        if (count($this->children) > 0) {
            return array_values($this->children);
        }

        return null;
    }

    public function getMenuItem(string $identifier): self
    {
        if (!isset($this->children[$identifier])) {
            throw new \Exception(sprintf('Menu item %s not found.', $identifier));
        }

        return $this->children[$identifier];
    }

    public function sortChildrens(): void
    {
        uasort($this->children, [$this, 'sortChilds']);
    }

    private function setTitle(bool $title): self
    {
        $this->title = $title;

        return $this;
    }

    private function sortChilds(MenuItemInterface $a, MenuItemInterface $b)
    {
        $a->sortChildrens();
        $b->sortChildrens();

        return $a->getSort() - $b->getSort();
    }
}
