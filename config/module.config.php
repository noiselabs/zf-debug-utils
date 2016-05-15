<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

use Noiselabs\ZfDebugModule\Factory\Controller\Console\RoutesControllerFactory as ConsoleRoutesControllerFactory;
use Noiselabs\ZfDebugModule\Factory\Controller\Http\IndexControllerFactory;
use Noiselabs\ZfDebugModule\Factory\Controller\Http\RoutesControllerFactory as HttpRoutesControllerFactory;

return [
    'controllers' => [
        'factories' => [
            ConsoleRoutesControllerFactory::SERVICE_NAME => ConsoleRoutesControllerFactory::class,
            IndexControllerFactory::SERVICE_NAME => IndexControllerFactory::class,
            HttpRoutesControllerFactory::SERVICE_NAME => HttpRoutesControllerFactory::class,
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'zf-debug-utils\router\list-all' => [
                    'options' => [
                        'route' => 'debug:router:list-all',
                        'defaults' => [
                            'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                            'action' => 'listAll',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'zf-debug-utils' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/_debug',
                    'defaults' => [
                        'controller' => IndexControllerFactory::SERVICE_NAME,
                        'action' => 'indexAction',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'zf-debug-utils' => __DIR__ . '/../Resources/views',
        ],
    ],
];
