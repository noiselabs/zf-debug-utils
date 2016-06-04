<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest;

use Noiselabs\ZfDebugModule\Module;
use Noiselabs\ZfDebugModule\Package;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Zend\EventManager\Event;
use Zend\Http\Request;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\ServiceManager\ServiceManager;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function testDependencyOnAssetManagerIsSet()
    {
        $module = new Module();
        $dependencies = $module->getModuleDependencies();
        $this->assertContains('AssetManager', $dependencies);
    }

    public function testCurrentRouteNameViewModelVariableIsSetOnBootstrap()
    {
        $currentRouteName = self::class;
        $application = $this->setUpApplication($currentRouteName);

        $mvcEvent = new MvcEvent();
        $mvcEvent->setApplication($application);

        $module = new Module();
        $module->onBootstrap($mvcEvent);

        $viewModel = $mvcEvent->getViewModel();

        $this->assertEquals($currentRouteName, $viewModel->getVariable('__currentRouteName'));
    }

    public function testNonMvcEventIsPassedToOnBootstrap()
    {
        $event = new Event();

        $module = new Module();
        $returnValue = $module->onBootstrap($event);
        $this->assertNull($returnValue);
    }

    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();

        $this->assertInternalType('array', $config);
        $this->assertSame($config, unserialize(serialize($config)));
    }

    public function testRootConfigKeysAreSet()
    {
        $module = new Module();
        $config = $module->getConfig();

        $this->assertTrue(isset($config['asset_manager']));
        $this->assertInternalType('array', $config['asset_manager']);
        $this->assertTrue(isset($config['controllers']['factories']));
        $this->assertInternalType('array', $config['controllers']['factories']);
        $this->assertTrue(isset($config['console']['router']['routes']));
        $this->assertInternalType('array', $config['console']['router']['routes']);
        $this->assertTrue(isset($config['router']['routes'][Package::NAME]));
        $this->assertInternalType('array', $config['router']['routes'][Package::NAME]);
        $this->assertTrue(isset($config['service_manager']['factories']));
        $this->assertInternalType('array', $config['service_manager']['factories']);
        $this->assertTrue(isset($config['view_manager']['template_map']));
        $this->assertInternalType('array', $config['view_manager']['template_map']);
    }

    /**
     * @param string $currentRouteName
     *
     * @return Application
     */
    private function setUpApplication($currentRouteName)
    {
        /** @var RouteMatch|PHPUnit_Framework_MockObject_MockObject $routeMatch */
        $routeMatch = $this
            ->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();
        $routeMatch
            ->expects($this->any())
            ->method('getMatchedRouteName')
            ->will($this->returnValue($currentRouteName));

        /** @var Request $request */
        $request = $this
            ->getMockBuilder(Request::class)
            ->getMock();

        /** @var RouteStackInterface|PHPUnit_Framework_MockObject_MockObject $router */
        $router = $this
            ->getMockBuilder(RouteStackInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router
            ->expects($this->any())
            ->method('match')
            ->with($request)
            ->will($this->returnValue($routeMatch));

        /** @var ServiceManager|PHPUnit_Framework_MockObject_MockObject $serviceManager */
        $serviceManager = $this
            ->getMockBuilder(ServiceManager::class)
            ->getMock();
        $serviceManager
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                ['request', true, $request],
                ['router', true, $router],
            ]));

        /** @var Application|PHPUnit_Framework_MockObject_MockObject $application */
        $application = $this
            ->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();
        $application
            ->expects($this->any())
            ->method('getServiceManager')
            ->will($this->returnValue($serviceManager));

        return $application;
    }
}
