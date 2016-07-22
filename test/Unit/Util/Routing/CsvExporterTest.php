<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Unit\Util\Routing;

use Noiselabs\ZfDebugModule\Util\Routing\CsvExporter;
use Noiselabs\ZfDebugModule\Util\Routing\FlatRouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\Route;
use PHPUnit_Framework_TestCase;

class CsvExporterTest extends PHPUnit_Framework_TestCase
{
    const ROUTES_COUNT = 10;

    public function testExport()
    {
        $routeCollection = $this->getRouteCollection();
        $outputDir = sys_get_temp_dir();

        $csvExporter = new CsvExporter($routeCollection, $outputDir);
        $file = $csvExporter->export();
        $this->assertTrue(is_file($file));
        $contents = file($file);
        $this->assertEquals(self::ROUTES_COUNT + 1, count($contents));

        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * @return FlatRouteCollection
     */
    private function getRouteCollection()
    {
        $routeCollection = new FlatRouteCollection();
        for ($i = 1; $i <= self::ROUTES_COUNT; $i++) {
            $routeCollection->addRoute(new Route('Route ' . $i, 'URL ' . $i, 'Controller ' . $i, 'Action ' . $i));
        }

        return $routeCollection;
    }
}
