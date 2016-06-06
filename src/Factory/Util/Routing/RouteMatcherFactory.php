<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteMatcherFactory implements FactoryInterface
{
    const SERVICE_NAME = RouteMatcher::class;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * 
     * @return RouteMatcher
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var RouteStackInterface $router */
        $router = $serviceLocator->get('router');

        return new RouteMatcher($router);
    }
}
