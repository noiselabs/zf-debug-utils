<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

use Zend\Mvc\Router\RouteInterface;

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
     * @return RouteCollection
     */
    public function build()
    {
        $routeCollection = new FlatRouteCollection();
        $this->processRoutes($routeCollection, $this->routes);

        return $routeCollection;
    }

    /**
     * @param FlatRouteCollection $routeCollection
     * @param array               $routesConfig
     * @param array               $parentRoutesConfig
     */
    private function processRoutes(FlatRouteCollection $routeCollection, array $routesConfig, array $parentRoutesConfig = null)
    {
        foreach (array_keys($routesConfig) as $k) {
            $routeName = $k;
            $routeUrl = isset($routesConfig[$k]['options']['route']) ? $routesConfig[$k]['options']['route'] : '';

            if (!empty($parentRoutesConfig)) {
                $pk = key($parentRoutesConfig);

                $routeName = $pk . '/' . $routeName;
                if (isset($parentRoutesConfig[$pk]['options']['route'])) {
                    $routeUrl = $parentRoutesConfig[$pk]['options']['route'] . $routeUrl;
                }
            }

            $controller = isset($routesConfig[$k]['options']['defaults']['controller'])
                ? $routesConfig[$k]['options']['defaults']['controller'] : null;
            $action = isset($routesConfig[$k]['options']['defaults']['action'])
                ? $routesConfig[$k]['options']['defaults']['action'] : null;
            $route = new Route($routeName, $routeUrl, $controller, $action);
            $routeCollection->addRoute($route);

            if (isset($routesConfig[$k]['child_routes']) && !empty($routesConfig[$k]['child_routes'])) {
                $childRoutes = $routesConfig[$k]['child_routes'];
                unset($routesConfig[$k]['child_routes']);
                $this->processRoutes($routeCollection, $childRoutes, [$k => $routesConfig[$k]]);
            }
        }
    }
}
