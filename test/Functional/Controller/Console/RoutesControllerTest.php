<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Functional\Controller\Console;

use Exception;
use Noiselabs\ZfDebugModule\Controller\Console\RoutesController;
use Noiselabs\ZfDebugModuleTest\Functional\Bootstrap;
use PHPUnit_Framework_ExpectationFailedException;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

class RoutesControllerTest extends AbstractConsoleControllerTestCase
{
    /**
     * @var string
     */
    private $content;

    public function setUp()
    {
        $this->setApplicationConfig(Bootstrap::getApplicationConfig());
        $this->content = '';
        parent::setUp();
    }

    public function tearDown()
    {
        unset($this->content);
    }

    public function testExportAction()
    {
        $this->dispatch('zfdebug routes export');

        $this->assertControllerName(RoutesController::class);
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('noiselabs/zf-debug-utils/router/export');
        $this->assertConsoleOutputContains('Exporting all routes... done.');
        $this->assertConsoleOutputContains('CSV file now available at ');
        $this->assertConsoleOutputContains('.csv');

        $this->removeGenerateCsvFile();
    }

    public function testListAction()
    {
        $this->dispatch('zfdebug routes list');

        $this->assertControllerName(RoutesController::class);
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('noiselabs/zf-debug-utils/router/list');
        $this->assertConsoleOutputContains('CONTROLLER::ACTION');
        $this->assertConsoleOutputContains('zf-debug-utils/routes/do-match-route');
        $this->assertConsoleOutputContains('Noiselabs\ZfDebugModule\Controller\Http\RoutesController::renderMatchRouteViewAction');
    }

    public function testMatchActionWithValidUrl()
    {
        $this->dispatch('zfdebug routes match GET /_debug/routes/match');

        $this->assertControllerName(RoutesController::class);
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('noiselabs/zf-debug-utils/router/match');
        $this->assertConsoleOutputContains('A match was found for GET "/_debug/routes/match');
        $this->assertConsoleOutputContains('zf-debug-utils/routes/match');
        $this->assertConsoleOutputContains('renderMatchRouteViewAction');
    }

    public function testMatchActionWithInvalidUrl()
    {
        $this->dispatch('zfdebug routes match GET /not-found');

        $this->assertControllerName(RoutesController::class);
        $this->assertControllerClass('RoutesController');
        $this->assertMatchedRouteName('noiselabs/zf-debug-utils/router/match');
        $this->assertConsoleOutputContains('No match found for GET "/not-found');
    }

    /**
     * Dispatch the MVC with a URL
     * Accept a HTTP (simulate a customer action) or console route.
     *
     * The URL provided set the request URI in the request object.
     *
     * @param string      $url
     * @param string|null $method
     * @param array|null  $params
     *
     * @throws Exception
     */
    public function dispatch($url, $method = null, $params = [], $isXmlHttpRequest = false)
    {
        ob_start();
        parent::dispatch($url, $method, $params, $isXmlHttpRequest);
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    /**
     * Assert console output contain content (insensible case).
     *
     * @param string $match content that should be contained in matched nodes
     */
    public function assertConsoleOutputContains($match)
    {
        if (false === stripos($this->content, $match)) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting output CONTAINS content "%s", actual content is "%s"',
                    $match,
                    $this->content
                )
            );
        }
        $this->assertNotSame(false, stripos($this->content, $match));
    }

    /**
     * Removes the CSV file generated in the exportAction().
     */
    private function removeGenerateCsvFile()
    {
        $lines = explode(PHP_EOL, $this->content);
        while ($line = array_shift($lines)) {
            preg_match('@^CSV file now available at [^/]*(/.*\.csv)@', $line, $matches);
            if (count($matches) != 2) {
                continue;
            }

            $file = $matches[1];
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
