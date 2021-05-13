<?php

declare(strict_types=1);

namespace Chubbyphp\Framework\Router\Aura;

use Aura\Router\Matcher;
use Aura\Router\Rule\Allows;
use Chubbyphp\Framework\Router\Exceptions\MethodNotAllowedException;
use Chubbyphp\Framework\Router\Exceptions\NotFoundException;
use Chubbyphp\Framework\Router\RouteInterface;
use Chubbyphp\Framework\Router\RouteMatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RouteMatcher implements RouteMatcherInterface
{
    public const PATH_DEFAULTS = 'defaults';
    public const PATH_HOST = 'host';
    public const PATH_SECURE = 'secure';
    public const PATH_SPECIAL = 'special';
    public const PATH_TOKENS = 'tokens';
    public const PATH_WILDCARD = 'wildcard';

    /**
     * @var array<string, RouteInterface>
     */
    private array $routesByName;

    private Matcher $matcher;

    public function __construct(Aura $aura)
    {
        $this->routesByName = $aura->getRoutesByName();
        $this->matcher = $aura->getMatcher();
    }

    public function match(ServerRequestInterface $request): RouteInterface
    {
        if (!$auraRoute = $this->matcher->match($request)) {
            $failedAuraRoute = $this->matcher->getFailedRoute();

            if (Allows::class === $failedAuraRoute->failedRule) {
                throw MethodNotAllowedException::create(
                    $request->getRequestTarget(),
                    $request->getMethod(),
                    $failedAuraRoute->allows
                );
            }

            throw NotFoundException::create($request->getRequestTarget());
        }

        $route = $this->routesByName[$auraRoute->name];

        return $route->withAttributes($auraRoute->attributes);
    }
}
