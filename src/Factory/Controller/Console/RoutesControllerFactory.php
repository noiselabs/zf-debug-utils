<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Controller\Console;

use Noiselabs\ZfDebugModule\Controller\Console\RoutesController;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteCollectionFactory;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteMatcherFactory;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Console\RoutesControllerFactory creates instances of Console\RoutesController.
 */
class RoutesControllerFactory implements FactoryInterface
{
    const SERVICE_NAME = RoutesController::class;

    /**
     * @param ServiceLocatorInterface|ControllerManager $serviceLocator
     *
     * @return RoutesController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $mainServiceManager */
        $mainServiceManager = $serviceLocator->getServiceLocator();

        /** @var RouteCollection $routeCollection */
        $routeCollection = $mainServiceManager->get(RouteCollectionFactory::SERVICE_NAME);
        /** @var RouteMatcher $routeMatcher */
        $routeMatcher = $mainServiceManager->get(RouteMatcherFactory::SERVICE_NAME);
        $console = $mainServiceManager->get('Console');

        return new RoutesController($routeCollection, $routeMatcher, $console);
    }
}
