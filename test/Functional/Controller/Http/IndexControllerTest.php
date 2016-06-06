<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Functional\Controller\Http;

use Noiselabs\ZfDebugModuleTest\Functional\Bootstrap;
use Zend\Http\Request;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(Bootstrap::getApplicationConfig());
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/_debug', Request::METHOD_GET);
        $this->assertResponseStatusCode(200);

        $this->assertControllerName('Noiselabs\ZfDebugModule\Controller\Http\IndexController');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('zf-debug-utils');
    }
}
