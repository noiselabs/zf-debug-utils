<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollectionBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteCollectionFactory implements FactoryInterface
{
    const SERVICE_NAME = RouteCollection::class;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * 
     * @return RouteCollection
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array $config */
        $config = $serviceLocator->get('config');
        $config = isset($config['router']['routes']) ? $config['router']['routes'] : [];

        $builder = new RouteCollectionBuilder($config);
        
        return $builder->build();
    }
}
