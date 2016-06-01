<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

use Zend\Mvc\Router\RouteInterface;

/**
 * RouteCollectionBuilder is only able to build FlatRouteCollection(s).
 */
class RouteCollectionBuilder
{
    /**
     * @var RouteInterface
     */
    private $routes;

    /**
     * RoutesInspector constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * @return FlatRouteCollection
     */
    public function build()
    {
        return $this->processRoutes(new FlatRouteCollection(), $this->routes);
    }

    /**
     * @param FlatRouteCollection $routeCollection
     * @param array               $routesConfig
     * @param Route               $parentRoute
     *
     * @return FlatRouteCollection
     */
    private function processRoutes(FlatRouteCollection $routeCollection, array $routesConfig, Route $parentRoute = null)
    {
        foreach (array_keys($routesConfig) as $k) {
            $childRoutes = null;
            if (isset($routesConfig[$k]['child_routes']) && !empty($routesConfig[$k]['child_routes'])) {
                $childRoutes = $routesConfig[$k]['child_routes'];
                unset($routesConfig[$k]['child_routes']);
            }

            $routesConfig[$k]['name'] = $k;
            $route = $this->processRoute($routesConfig[$k], $parentRoute);
            if (!isset($routesConfig[$k]['may_terminate']) || false !== $routesConfig[$k]['may_terminate']) {
                $routeCollection->addRoute($route);
            }

            if (null !== $childRoutes) {
                $this->processRoutes($routeCollection, $childRoutes, $route);
            }
        }

        return $routeCollection;
    }

    /**
     * @param array      $routeConfig
     * @param Route|null $parentRoute
     *
     * @return Route
     */
    private function processRoute(array $routeConfig, Route $parentRoute = null)
    {
        $name = $routeConfig['name'];
        $url = isset($routeConfig['options']['route']) ? $routeConfig['options']['route'] : '';
        $controller = isset($routeConfig['options']['defaults']['controller'])
            ? $routeConfig['options']['defaults']['controller'] : null;
        $action = isset($routeConfig['options']['defaults']['action'])
            ? $routeConfig['options']['defaults']['action'] : null;

        if (null !== $parentRoute) {
            $name = $parentRoute->getName() . '/' . $name;
            $url = $parentRoute->getUrl() . $url;
            if (null === $controller) {
                $controller = $parentRoute->getController();
            }
        }

        return new Route($name, $url, $controller, $action);
    }
}
