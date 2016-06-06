<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Controller\Http;

use Noiselabs\ZfDebugModule\Module;
use Noiselabs\ZfDebugModule\Package;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $this->layout(Module::DEFAULT_LAYOUT);
        $view = new ViewModel([]);
        $view->setTemplate(Package::FQPN . '/index/index');

        return $view;
    }
}
