<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

class FlatRouteCollection implements RouteCollection
{
    /**
     * @var array
     */
    private $routes;

    /**
     * RouteCollection constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    /**
     * @param bool $sort
     *
     * @return array|\Traversable
     */
    public function getRoutes($sort = true)
    {
        if (true === $sort) {
            ksort($this->routes, SORT_NATURAL);
        }

        return $this->routes;
    }
}
