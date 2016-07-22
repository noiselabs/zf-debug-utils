<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Controller\Console;

use Noiselabs\ZfDebugModule\Util\Routing\CsvExporter;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;

class RoutesController extends AbstractActionController
{
    /**
     * @var Console
     */
    private $console;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var RouteMatcher
     */
    private $routeMatcher;

    /**
     * RoutesController constructor.
     *
     * @param RouteCollection $routeCollection
     * @param RouteMatcher    $routeMatcher
     * @param Console         $console
     */
    public function __construct(RouteCollection $routeCollection, RouteMatcher $routeMatcher, Console $console)
    {
        $this->routeCollection = $routeCollection;
        $this->routeMatcher = $routeMatcher;
        $this->console = $console;
    }

    public function exportAction()
    {
        $csvExporter = new CsvExporter($this->routeCollection, sys_get_temp_dir());
        $this->console->write('Exporting all routes...');
        $fileName = $csvExporter->export();
        $this->console->writeLine(' done.');

        $this->console->write('CSV file now available at ');
        $this->console->writeLine($fileName, ColorInterface::LIGHT_BLUE);
    }

    public function listAction()
    {
        $this->console->write('{ ', ColorInterface::GRAY);
        $this->console->write('ROUTE', ColorInterface::GREEN);
        $this->console->write(', ', ColorInterface::GRAY);
        $this->console->write('URL ', ColorInterface::BLUE);
        $this->console->write(', ', ColorInterface::GRAY);
        $this->console->write('CONTROLLER::ACTION', ColorInterface::RED);
        $this->console->writeLine(' }', ColorInterface::GRAY);
        $this->console->writeLine('');

        foreach ($this->routeCollection->getRoutes() as $route) {
            $this->console->write('{ ', ColorInterface::GRAY);
            $this->console->write($route->getName(), ColorInterface::GREEN);
            $this->console->write(', ', ColorInterface::GRAY);
            $this->console->write($route->getUrl(), ColorInterface::BLUE);
            $this->console->write(', ', ColorInterface::GRAY);
            $this->console->write(sprintf('%s::%s', $route->getController(), $route->getAction()),
                ColorInterface::RED);
            $this->console->writeLine(' }', ColorInterface::GRAY);
        }
    }

    public function matchAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $method = strtoupper($request->getParam('method'));
        $url = $request->getParam('url');

        $match = $this->routeMatcher->match($method, $url);
        if (null !== $match) {
            $route = $this->routeCollection->getRoute($match);

            $this->console->writeLine(sprintf('A match was found for %s "%s"', $method, $url), ColorInterface::GREEN);
            $this->console->write('        Name:  ');
            $this->console->writeLine($route->getName(), ColorInterface::LIGHT_WHITE);
            $this->console->write('         URL:  ');
            $this->console->writeLine($route->getUrl(), ColorInterface::LIGHT_WHITE);
            $this->console->write('  Controller:  ');
            $this->console->writeLine($route->getController(), ColorInterface::LIGHT_WHITE);
            $this->console->write('      Action:  ');
            $this->console->writeLine($route->getAction(), ColorInterface::LIGHT_WHITE);
        } else {
            $this->console->writeLine(sprintf('No match found for %s "%s"', $method, $url), ColorInterface::RED);
        }
    }
}
