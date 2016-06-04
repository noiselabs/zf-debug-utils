<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\Route;
use PHPUnit_Framework_TestCase;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function testImmutable()
    {
        $route = new Route('name', 'url', 'controller', 'action');
        $this->assertEquals('name', $route->getName());
        $this->assertEquals('url', $route->getUrl());
        $this->assertEquals('controller', $route->getController());
        $this->assertEquals('action', $route->getAction());
    }
}
