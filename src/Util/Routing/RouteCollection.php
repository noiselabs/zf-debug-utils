<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

interface RouteCollection
{
    /**
     * @param string $routeName
     * 
     * @return Route
     */
    public function getRoute($routeName);

    /**
     * @return Route[]
     */
    public function getRoutes();
}
