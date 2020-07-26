<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Route\Service;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Route;

class Routes
{
    // Available Angular components
    private const DETAIL_COMPONENT = 'DetailComponent';
    private const LIST_COMPONENT = 'ListComponent';
    private const HTML_COMPONENT = 'HtmlComponent';

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getAdminRoutes(): array
    {
        $routes = $this->router->getRouteCollection();

        /** @var Route $route */
        foreach ($routes->all() as $name => $route) {
            $component = $this->getComponent($name, $route->getOption('component'));
            if($component) {
                $result[] = [
                    'path'      => str_replace(['/backend/', '{id}'], ['', ':id'], $route->getPath()),
                    'component' => $component,
                    'runGuardsAndResolvers' => 'always',
                    'data' => [
                        'operation' => $this->getOperation($name)
                    ],
                    'resolve' => $this->getResolver($component)
                ];
            }
        }

        return $result;
    }

    private function getComponent(string $route, string $component = null): ?string
    {
        if($component) {
            return $component;
        }

        if(stripos($route, '.list') !== false && $this->isAdminRoute($route)) {
            return self::LIST_COMPONENT;
        }

        if(stripos($route, '.create') !== false && $this->isAdminRoute($route)) {
            return self::DETAIL_COMPONENT;
        }

        if(stripos($route, '.update') !== false && $this->isAdminRoute($route)) {
            return self::DETAIL_COMPONENT;
        }

        return null;
    }

    private function getOperation(string $route): ?string
    {
        if(stripos($route, '.create') !== false) {
            return 'create';
        }

        if(stripos($route, '.update') !== false) {
            return 'edit';
        }

        return null;
    }

    private function getResolver(string $component): array
    {
        if($component === self::LIST_COMPONENT) {
            return ['config' => 'ListResolver'];
        }

        if($component === self::HTML_COMPONENT) {
            return ['html' => 'HtmlResolver'];
        }

        return ['form' => 'DetailResolver'];
    }

    private function isAdminRoute(string $name): bool
    {
        return stripos($name, 'admin.') !== false;
    }
}