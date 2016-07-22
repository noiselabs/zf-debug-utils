<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Util\Routing;

use DateTime;
use Noiselabs\ZfDebugModule\Package;

class CsvExporter
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var string
     */
    private $outputDir;

    /**
     * CsvExporter constructor.
     *
     * @param RouteCollection $routeCollection
     * @param string          $outputDir
     */
    public function __construct(RouteCollection $routeCollection, $outputDir)
    {
        $this->routeCollection = $routeCollection;
        $this->outputDir = rtrim($outputDir, '/');
    }

    /**
     * @return string
     */
    public function export()
    {
        $datetime = DateTime::createFromFormat('U.u', microtime(true));
        $fileName = sprintf('%s/%s_routes_%s.csv', $this->outputDir, Package::NAME, $datetime->format('Ymd-His.u'));

        $fp = fopen($fileName, 'w');
        fputcsv($fp, ['Route name', 'URL', 'Controller', 'Action']);
        foreach ($this->routeCollection->getRoutes() as $route) {
            /* @var Route $route */
            fputcsv($fp, [$route->getName(), $route->getUrl(), $route->getController(), $route->getAction()]);
        }
        fclose($fp);

        return $fileName;
    }
}
