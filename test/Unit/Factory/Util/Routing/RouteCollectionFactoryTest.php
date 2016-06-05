<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuleTest\Unit\Factory\Util\Routing;

use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteCollectionFactory;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

class RouteCollectionFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        /** @var ServiceManager|PHPUnit_Framework_MockObject_MockObject $serviceManager */
        $serviceManager = $this
            ->getMockBuilder(ServiceManager::class)
            ->getMock();
        $serviceManager
            ->expects($this->any())
            ->method('get')
            ->with('config')
            ->will($this->returnValue([]));

        $factory = new RouteCollectionFactory();
        $routeCollection = $factory->createService($serviceManager);
        $this->assertInstanceOf(RouteCollection::class, $routeCollection);
    }

    public function testServiceNameIsDefined()
    {
        $this->assertTrue(defined(RouteCollectionFactory::class . '::SERVICE_NAME'));
    }
}
