<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

return [
    'modules' => [
        'AssetManager',
        'Noiselabs\ZfDebugModule',
    ],
    'module_listener_options' => [
        'module_paths' => [
            __DIR__ . '/../../../src',
            __DIR__ . '/../../../vendor',
        ],
    ],
];
