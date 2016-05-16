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
use Noiselabs\ZfDebugModule\Package;

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
                Package::FQPN . '/router/list-all' => [
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
            Package::FQPN => [
                'type' => 'literal',
                'options' => [
                    'route' => '/_debug',
                    'defaults' => [
                        'controller' => IndexControllerFactory::SERVICE_NAME,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'routes' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/routes',
                            'defaults' => [
                                'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                                'action' => 'listAll',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            Package::FQPN . '/index/index' => __DIR__ . '/../views/index/index.phtml',
            Package::FQPN . '/layout' => __DIR__ . '/../views/layout/layout.phtml',
            Package::FQPN . '/routes/list-all' => __DIR__ . '/../views/routes/list-all.phtml',
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'aliases' => [
                Package::FQPN => __DIR__ . '/../public',
            ],
        ],
    ],
];
