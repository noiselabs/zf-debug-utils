<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule\Controller\Console;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;

class RoutesController extends AbstractActionController
{
    public function listAll()
    {
        throw new RuntimeException('not there yet');
    }
}
