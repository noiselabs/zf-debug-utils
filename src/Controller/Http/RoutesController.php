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
use Noiselabs\ZfDebugModule\Util\Routing\RouteMatcher;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RoutesController extends AbstractActionController
{
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
     * @param RouteMatcher $routeMatcher
     */
    public function __construct(RouteCollection $routeCollection, RouteMatcher $routeMatcher)
    {
        $this->routeCollection = $routeCollection;
        $this->routeMatcher = $routeMatcher;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->redirect()->toRoute(Package::NAME . '/routes/list');
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

    /**
     * @return ViewModel
     */
    public function renderMatchRouteViewAction()
    {
        $this->layout(Module::DEFAULT_LAYOUT);
        $view = new ViewModel();
        $view->setTemplate(Package::FQPN . '/routes/match');

        return $view;
    }

    /**
     * @return JsonModel
     */
    public function matchRouteAction()
    {
        $data = $this->params()->fromQuery();
        $route = null;
        if (isset($data['method']) && !empty($data['method']) && isset($data['url']) && !empty($data['url'])) {
            if (null !== ($routeName = $this->routeMatcher->match($data['method'], $data['url']))) {
                $route = $this->routeCollection->getRoute($routeName);
                $route = [
                    'name' => $route->getName(),
                    'url' => $route->getUrl(),
                    'controller' => $route->getController(),
                    'action' => $route->getAction(),
                ];
            }
        }

        return new JsonModel(['requestedRouteData' => $data, 'routeMatch' => $route]);
    }
}
