<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuleTest\Unit\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\FlatRouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\Route;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class FlatRouteCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testImplementsRouteCollection()
    {
        $r = new ReflectionClass(FlatRouteCollection::class);
        $this->assertTrue($r->implementsInterface(RouteCollection::class));
    }

    public function testGetRoutesWhenSetInConstructor()
    {
        $routes = ['a' => $this->createRoute('a'), 'b' => $this->createRoute('b')];
        $routeCollection = new FlatRouteCollection(array_values($routes));
        $this->assertEquals($routes, $routeCollection->getRoutes(false));
    }

    public function testGetRoutesAreAlphabeticallySorted()
    {
        $routes = [
            $this->createRoute('b'),
            $this->createRoute('a'),
            $this->createRoute('a/c'),
            $this->createRoute('a/b'),
            $this->createRoute('a/b/c'),
            $this->createRoute('a/b/a'),
        ];

        $routeCollection = new FlatRouteCollection($routes);
        $returnedRoutes = $routeCollection->getRoutes();

        foreach (['a', 'a/b', 'a/b/a', 'a/b/c', 'a/c', 'b'] as $routeName) {
            $route = array_shift($returnedRoutes);
            $this->assertEquals($routeName, $route->getName());
        }
    }

    public function testGetRoute()
    {
        // Set via constructor
        $route = $this->createRoute('a');
        $routeCollection = new FlatRouteCollection([$route]);
        $this->assertEquals($route, $routeCollection->getRoute('a'));
        unset($route, $routeCollection);

        // Set via addRoute()
        $route = $this->createRoute('a');
        $routeCollection = new FlatRouteCollection();
        $routeCollection->addRoute($route);
        $this->assertEquals($route, $routeCollection->getRoute('a'));
    }

    public function testGetRouteReturnsNullIfNotFound()
    {
        $routeCollection = new FlatRouteCollection([]);
        $this->assertNull($routeCollection->getRoute('a'));
    }

    public function testSettingRouteWithSameNameOverridesThePreviousOne()
    {
        $route1 = new Route('a', 'url-1', 'controller-1', 'action-1');
        $route2 = new Route('a', 'url-2', 'controller-2', 'action-2');
        $route3 = new Route('a', 'url-3', 'controller-3', 'action-3');

        // Set via constructor
        $routes = [$route1, $route2, $route3];
        $routeCollection = new FlatRouteCollection($routes);
        $this->assertEquals($route3, $routeCollection->getRoute('a'));
        unset($routes, $routeCollection);

        // Set via addRoute()
        $routeCollection = new FlatRouteCollection();
        $routeCollection->addRoute($route1);
        $routeCollection->addRoute($route2);
        $routeCollection->addRoute($route3);
        $this->assertEquals($route3, $routeCollection->getRoute('a'));
    }

    /**
     * @param string $name
     *
     * @return Route
     */
    private function createRoute($name)
    {
        return new Route($name, $name . '-url', $name . '-controller', $name . '-action');
    }
}
