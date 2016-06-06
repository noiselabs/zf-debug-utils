<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuletest\Functional;

class Bootstrap
{
    /**
     * @return array
     */
    public static function getApplicationConfig()
    {
        return require __DIR__ . '/config/application.config.php';
    }
}
