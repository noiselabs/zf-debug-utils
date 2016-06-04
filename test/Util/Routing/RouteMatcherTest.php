<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface;

class RouteMatcherTest extends PHPUnit_Framework_TestCase
{
    public function testMatchReturnsNull()
    {
        /** @var RouteStackInterface|PHPUnit_Framework_MockObject_MockObject $router */
        $router = $this
            ->getMockBuilder(RouteStackInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router
            ->expects($this->any())
            ->method('match')
            ->will($this->returnValue(null));

        $routeMatcher = new RouteMatcher($router);
        $this->assertNull($routeMatcher->match('GET', '/some/url'));
    }

    public function testMatchReturnsMatchedRouteName()
    {
        $routeName = 'some-route';
        $routeMatch = $this->createRouteMatch($routeName);

        /** @var RouteStackInterface|PHPUnit_Framework_MockObject_MockObject $router */
        $router = $this
            ->getMockBuilder(RouteStackInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router
            ->expects($this->any())
            ->method('match')
            ->will($this->returnValue($routeMatch));

        $routeMatcher = new RouteMatcher($router);
        $this->assertEquals($routeName, $routeMatcher->match('GET', '/some/url'));
    }

    /**
     * @param string $matchedRouteName
     *
     * @return RouteMatch
     */
    private function createRouteMatch($matchedRouteName)
    {
        /** @var RouteMatch|PHPUnit_Framework_MockObject_MockObject $routeMatch */
        $routeMatch = $this
            ->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();
        $routeMatch
            ->expects($this->any())
            ->method('getMatchedRouteName')
            ->will($this->returnValue($matchedRouteName));

        return $routeMatch;
    }
}
