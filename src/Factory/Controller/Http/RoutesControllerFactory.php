<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Controller\Http;

use Noiselabs\ZfDebugModule\Controller\Http\RoutesController;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteCollectionFactory;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteMatcherFactory;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Http\RoutesControllerFactory creates instances of Http\RoutesController.
 */
class RoutesControllerFactory implements FactoryInterface
{
    const SERVICE_NAME = RoutesController::class;

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var ControllerManager $serviceLocator */
        $mainServiceLocator = $serviceLocator->getServiceLocator();
        /** @var RouteCollection $routeCollection */
        $routeCollection = $mainServiceLocator->get(RouteCollectionFactory::SERVICE_NAME);
        /** @var RouteMatcher $routeMatcher */
        $routeMatcher = $mainServiceLocator->get(RouteMatcherFactory::SERVICE_NAME);

        return new RoutesController($routeCollection, $routeMatcher);
    }
}
