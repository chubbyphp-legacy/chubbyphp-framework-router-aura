<?php

declare(strict_types=1);

namespace Chubbyphp\Framework\Router\Aura;

use Aura\Router\Generator;
use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use Chubbyphp\Framework\Router\RouteInterface;
use Chubbyphp\Framework\Router\RoutesInterface;

final class Aura
{
    /**
     * @var array<string, RouteInterface>
     */
    private array $routesByName;

    private RouterContainer $routerContainer;

    public function __construct(RoutesInterface $routes)
    {
        $this->routesByName = $routes->getRoutesByName();
        $this->routerContainer = $this->createRouterContainer($this->routesByName);
    }

    /**
     * @param array<string, RouteInterface> $routesByName
     */
    private function createRouterContainer(array $routesByName): RouterContainer
    {
        $routerContainer = new RouterContainer();

        $map = $routerContainer->getMap();

        foreach ($routesByName as $route) {
            $options = $route->getPathOptions();

            $auraRoute = $map->route($route->getName(), $route->getPath());
            $auraRoute->allows($route->getMethod());

            $auraRoute->defaults($options[RouteMatcher::PATH_DEFAULTS] ?? []);
            $auraRoute->host($options[RouteMatcher::PATH_HOST] ?? null);
            $auraRoute->secure($options[RouteMatcher::PATH_SECURE] ?? null);
            $auraRoute->special($options[RouteMatcher::PATH_SPECIAL] ?? null);
            $auraRoute->tokens($options[RouteMatcher::PATH_TOKENS] ?? []);
            $auraRoute->wildcard($options[RouteMatcher::PATH_WILDCARD] ?? null);
        }

        return $routerContainer;
    }

    /**
     * @return <string, RouteInterface>
     */
    public function getRoutesByName(): array
    {
        return $this->routesByName;
    }

    public function getMatcher(): Matcher
    {
        return $this->routerContainer->getMatcher();
    }

    public function getGenerator(): Generator
    {
        return $this->routerContainer->getGenerator();
    }
}
