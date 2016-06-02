<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Factory\Util\Routing;

use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteMatcherFactory;
use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\ServiceManager\ServiceManager;

class RouteMatcherFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        /** @var RouteStackInterface $router */
        $router = $this
            ->getMockBuilder(RouteStackInterface::class)
            ->getMock();

        /** @var ServiceManager|PHPUnit_Framework_MockObject_MockObject $serviceManager */
        $serviceManager = $this
            ->getMockBuilder(ServiceManager::class)
            ->getMock();
        $serviceManager
            ->expects($this->any())
            ->method('get')
            ->with('router')
            ->will($this->returnValue($router));

        $factory = new RouteMatcherFactory();
        $routeMatcher = $factory->createService($serviceManager);
        $this->assertInstanceOf(RouteMatcher::class, $routeMatcher);
    }
}
