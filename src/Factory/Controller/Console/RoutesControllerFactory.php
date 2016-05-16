<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Factory\Controller\Console;

use Noiselabs\ZfDebugModule\Controller\Console\RoutesController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Console\RoutesControllerFactory creates instances of Console\RoutesController.
 */
class RoutesControllerFactory implements FactoryInterface
{
    const SERVICE_NAME = RoutesController::class;

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RoutesController();
    }
}
