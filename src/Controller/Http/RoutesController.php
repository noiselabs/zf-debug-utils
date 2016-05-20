<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Controller\Http;

use Noiselabs\ZfDebugModule\Module;
use Noiselabs\ZfDebugModule\Package;
use Noiselabs\ZfDebugModule\Util\Routing\RouteCollection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoutesController extends AbstractActionController
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * RoutesController constructor.
     *
     * @param RouteCollection $routeCollection
     */
    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    /**
     * @return ViewModel
     */
    public function listAllAction()
    {
        $this->layout(Module::DEFAULT_LAYOUT);
        $view = new ViewModel([
            'routeCollection' => $this->routeCollection,
        ]);
        $view->setTemplate(Package::FQPN . '/routes/list-all');

        return $view;
    }
}
