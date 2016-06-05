<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Functional\Controller\Http;

use Noiselabs\ZfDebugModuleTest\Functional\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class RoutesControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(Bootstrap::getApplicationConfig());
        parent::setUp();
    }

    public function testRoutesUrlRedirectToListPage()
    {
        $this->dispatch('/_debug/routes');
        $this->assertRedirectTo('/_debug/routes/list');
    }

    public function testListActionCanBeAccessed()
    {
        $this->dispatch('/_debug/routes/list', Request::METHOD_GET);
        $this->assertResponseStatusCode(200);

        $this->assertControllerName('Noiselabs\ZfDebugModule\Controller\Http\RoutesController');
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('zf-debug-utils/routes/list');
    }

    public function testRenderMatchRouteViewAction()
    {
        $this->dispatch('/_debug/routes/match', Request::METHOD_GET);
        $this->assertResponseStatusCode(200);

        $this->assertControllerName('Noiselabs\ZfDebugModule\Controller\Http\RoutesController');
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('zf-debug-utils/routes/match');
    }

    public function testMatchRouteAction()
    {
        $this->dispatch('/_debug/routes/match-route', Request::METHOD_GET, [
            'method' => Request::METHOD_GET,
            'url' => '/_debug/routes/list',
        ]);

        $this->assertControllerName('Noiselabs\ZfDebugModule\Controller\Http\RoutesController');
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('zf-debug-utils/routes/do-match-route');

        /** @var Response $response */
        $response = $this->getResponse();
        $this->assertResponseStatusCode(200);
        $this->assertResponseHeaderContains('content-type', 'application/json; charset=utf-8');
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('GET', $content['requestedRouteData']['method']);
        $this->assertEquals('/_debug/routes/list', $content['requestedRouteData']['url']);
        $this->assertEquals('zf-debug-utils/routes/list', $content['routeMatch']['name']);
        $this->assertEquals('/_debug/routes/list', $content['routeMatch']['url']);
        $this->assertEquals('Noiselabs\ZfDebugModule\Controller\Http\RoutesController', $content['routeMatch']['controller']);
        $this->assertEquals('listAllAction', $content['routeMatch']['action']);
    }
}
