<?php

declare(strict_types=1);

namespace Chubbyphp\Framework\Router\Aura;

use Chubbyphp\Framework\Router\RouteInterface;
use Chubbyphp\Framework\Router\RouterInterface;
use Chubbyphp\Framework\Router\Routes;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @deprecated
 */
final class Router implements RouterInterface
{
    public const PATH_DEFAULTS = 'defaults';
    public const PATH_HOST = 'host';
    public const PATH_SECURE = 'secure';
    public const PATH_SPECIAL = 'special';
    public const PATH_TOKENS = 'tokens';
    public const PATH_WILDCARD = 'wildcard';

    private RouteMatcher $routeMatcher;
    private UrlGenerator $urlGenerator;

    /**
     * @param array<int, RouteInterface> $routes
     */
    public function __construct(array $routes, string $basePath = '')
    {
        $aura = new Aura(new Routes($routes));

        $this->routeMatcher = new RouteMatcher($aura);
        $this->urlGenerator = new UrlGenerator($aura, $basePath);
    }

    public function match(ServerRequestInterface $request): RouteInterface
    {
        return $this->routeMatcher->match($request);
    }

    /**
     * @param array<string, string> $attributes
     * @param array<string, mixed>  $queryParams
     */
    public function generateUrl(
        ServerRequestInterface $request,
        string $name,
        array $attributes = [],
        array $queryParams = []
    ): string {
        return $this->urlGenerator->generateUrl($request, $name, $attributes, $queryParams);
    }

    /**
     * @param array<string, string> $attributes
     * @param array<string, mixed>  $queryParams
     */
    public function generatePath(string $name, array $attributes = [], array $queryParams = []): string
    {
        return $this->urlGenerator->generatePath($name, $attributes, $queryParams);
    }
}
