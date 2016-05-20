<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\RequestInterface;

/**
 * ZfDebug Module.
 *
 * @author Vítor Brandão <vitor@noiselabs.org>
 */
class Module implements BootstrapListenerInterface, ConfigProviderInterface, DependencyIndicatorInterface
{
    const DEFAULT_LAYOUT = 'noiselabs/zf-debug-utils/layout';

    /**
     * {@inheritdoc}
     */
    public function getModuleDependencies()
    {
        return ['AssetManager'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return require __DIR__ . '/Resources/config/module.config.php';
    }

    /**
     * Listen to the bootstrap event.
     *
     * @param EventInterface|MvcEvent $e
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        if (!$e instanceof EventInterface) {
            return;
        }

        $currentRouteName = $this->getCurrentRouteName($e->getApplication()->getServiceManager());
        $e->getViewModel()->setVariables(['__currentRouteName' => $currentRouteName]);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return null|string
     */
    private function getCurrentRouteName(ServiceLocatorInterface $serviceLocator)
    {
        /** @var RouteInterface $router */
        $router = $serviceLocator->get('router');
        /** @var RequestInterface $request */
        $request = $serviceLocator->get('request');
        /** @var RouteMatch|null $matchedRoute */
        $matchedRoute = $router->match($request);

        return ($matchedRoute instanceof RouteMatch) ? $matchedRoute->getMatchedRouteName() : null;
    }
}
