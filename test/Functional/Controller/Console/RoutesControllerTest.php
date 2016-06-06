<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Functional\Controller\Console;

use Noiselabs\ZfDebugModule\Controller\Console\RoutesController;
use Noiselabs\ZfDebugModuleTest\Functional\Bootstrap;
use RuntimeException;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

class RoutesControllerTest extends AbstractConsoleControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(Bootstrap::getApplicationConfig());
        parent::setUp();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRoutesControllerThrowsRuntimeException()
    {
        $controller = new RoutesController();
        $controller->listAll();
    }
}
