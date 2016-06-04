<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModuleTest;

use Noiselabs\ZfDebugModule\Package;
use PHPUnit_Framework_TestCase;

class PackageTest extends PHPUnit_Framework_TestCase
{
    public function testConstantsAreDefined()
    {
        $consts = ['VENDOR', 'NAME', 'FQPN', 'DESCRIPTION', 'VERSION'];
        foreach ($consts as $const) {
            $this->assertTrue(defined(Package::class . '::' . $const));
        }
    }
}
