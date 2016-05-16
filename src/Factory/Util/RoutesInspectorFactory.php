<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Util;

use Noiselabs\ZfDebugModule\Util\RoutesInspector;
use Zend\Mvc\Router\RouteInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoutesInspectorFactory implements FactoryInterface
{
    const SERVICE_NAME = RoutesInspector::class;

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array $config */
        $config = $serviceLocator->get('config');
        $config = isset($config['router']['routes']) ? $config['router']['routes'] : [];

        /** @var RouteInterface $router */
        $router = $serviceLocator->get('router');

        return new RoutesInspector($router, $config);
    }
}
