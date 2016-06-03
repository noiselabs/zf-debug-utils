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
     * @var Route[]
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
     * @param string $routeName
     *
     * @return Route|null
     */
    public function getRoute($routeName)
    {
        if (!isset($this->routes[$routeName])) {
            return null;
        }
        
        return $this->routes[$routeName];
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
