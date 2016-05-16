<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util;

use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\SimpleRouteStack;

class RoutesInspector
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var RouteInterface
     */
    private $router;

    /**
     * RoutesInspector constructor.
     *
     * @param RouteInterface $router
     * @param array          $config
     */
    public function __construct(RouteInterface $router, array $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * @return array|\Traversable
     */
    public function getRoutes()
    {
        if ($this->router instanceof SimpleRouteStack) {
            /** @var SimpleRouteStack $router */
            $router = $this->router;

            return $router->getRoutes();
        }

        return [];
    }
}
