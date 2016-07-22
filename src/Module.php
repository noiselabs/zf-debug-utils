<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
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
class Module implements BootstrapListenerInterface, ConfigProviderInterface, ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface, InitProviderInterface
{
    const DEFAULT_LAYOUT = 'noiselabs/zf-debug-utils/layout';

    /**
     * {@inheritdoc}
     */
    public function init(ModuleManagerInterface $manager)
    {
        $manager->loadModule('AssetManager');
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
     * @return array|void
     */
    public function onBootstrap(EventInterface $e)
    {
        if (!$e instanceof MvcEvent) {
            return;
        }

        $currentRouteName = $this->getCurrentRouteName($e->getApplication()->getServiceManager());
        $e->getViewModel()->setVariables(['__currentRouteName' => $currentRouteName]);
    }

    /**
     * {@inheritdoc}
     *
     * @param Console $console
     *
     * @return string
     */
    public function getConsoleBanner(Console $console)
    {
        return sprintf('%s v%s', Package::NAME, Package::VERSION);
    }

    /**
     * @param Console $console
     *
     * @return array
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            '[ Routing ]',
            '',
            'zfdebug routes export' => 'Exports all routes in CSV format',
            'zfdebug routes list' => 'Lists all routes',
            'zfdebug routes match [METHOD] [URL]' => 'Matches a URL to a Route',
            ['Examples:'],
            ['$ zfdebug routes export', ''],
            ['$ zfdebug routes list', ''],
            ['$ zfdebug routes match GET /users/123', ''],
            ['$ zfdebug routes match POST /login', ''],
        ];
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
