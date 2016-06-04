<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\FlatRouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollectionBuilder;
use PHPUnit_Framework_TestCase;

class RouteCollectionBuilderTest extends PHPUnit_Framework_TestCase
{
    public function testBuilder()
    {
        $routesConfig = $this->getRoutesConfig();
        $builder = new RouteCollectionBuilder($routesConfig);

        $routeCollection = $builder->build();
        $this->assertInstanceOf(FlatRouteCollection::class, $routeCollection);

        $routes = $routeCollection->getRoutes();

        // "zf-debug-utils"
        $route = array_shift($routes);
        $this->assertEquals('zf-debug-utils', $route->getName());
        $this->assertEquals('/_debug', $route->getUrl());
        $this->assertEquals('IndexController', $route->getController());
        $this->assertEquals('indexAction', $route->getAction());

        // "zf-debug-utils/routes"
        $route = array_shift($routes);
        $this->assertEquals('zf-debug-utils/routes', $route->getName());
        $this->assertEquals('/_debug/routes', $route->getUrl());
        $this->assertEquals('HttpRoutesController', $route->getController());
        $this->assertEquals('indexAction', $route->getAction());

        // "zf-debug-utils/routes/do-match-route"
        $route = array_shift($routes);
        $this->assertEquals('zf-debug-utils/routes/do-match-route', $route->getName());
        $this->assertEquals('/_debug/routes/match-route', $route->getUrl());
        $this->assertEquals('HttpRoutesController', $route->getController());
        $this->assertEquals('matchRouteAction', $route->getAction());

        // "zf-debug-utils/routes/list"
        $route = array_shift($routes);
        $this->assertEquals('zf-debug-utils/routes/list', $route->getName());
        $this->assertEquals('/_debug/routes/list', $route->getUrl());
        $this->assertEquals('HttpRoutesController', $route->getController());
        $this->assertEquals('listAllAction', $route->getAction());

        // "zf-debug-utils/routes/match"
        $route = array_shift($routes);
        $this->assertEquals('zf-debug-utils/routes/match', $route->getName());
        $this->assertEquals('/_debug/routes/match', $route->getUrl());
        $this->assertEquals('HttpRoutesController', $route->getController());
        $this->assertEquals('renderMatchRouteViewAction', $route->getAction());
    }

    /**
     * @return array
     */
    private function getRoutesConfig()
    {
        return require __DIR__ . '/Fixtures/routes.config.php';
    }
}
