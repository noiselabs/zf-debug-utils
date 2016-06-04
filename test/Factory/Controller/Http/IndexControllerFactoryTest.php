<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Factory\Controller\Http;

use Noiselabs\ZfDebugModule\Controller\Http\IndexController;
use Noiselabs\ZfDebugModule\Factory\Controller\Http\IndexControllerFactory;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class IndexControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        /** @var ServiceManager|PHPUnit_Framework_MockObject_MockObject $serviceManager */
        $serviceManager = $this
            ->getMockBuilder(ServiceManager::class)
            ->getMock();

        /** @var ControllerManager|PHPUnit_Framework_MockObject_MockObject $controllerManager */
        $controllerManager = $this
            ->getMockBuilder(ControllerManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $controllerManager
            ->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($serviceManager));

        $factory = new IndexControllerFactory();
        $controller = $factory->createService($controllerManager);
        $this->assertInstanceOf(IndexController::class, $controller);
    }

    public function testServiceNameIsDefined()
    {
        $this->assertTrue(defined(IndexControllerFactory::class . '::SERVICE_NAME'));
    }
}
