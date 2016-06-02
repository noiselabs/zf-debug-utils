<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface;

class RouteMatcher
{
    /**
     * @var RouteStackInterface
     */
    private $router;

    /**
     * RouteMatcher constructor.
     *
     * @param RouteStackInterface $router
     */
    public function __construct(RouteStackInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $method
     * @param string $url
     * @return null|string
     */
    public function match($method, $url)
    {
        $request = new Request();
        $request->setMethod($method);
        $request->setUri($url);

        $routeMatch = $this->router->match($request);
        return ($routeMatch instanceof RouteMatch) ? $routeMatch->getMatchedRouteName() : null;
    }
}