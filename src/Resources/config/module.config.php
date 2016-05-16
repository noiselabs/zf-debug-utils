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
            Package::NAME => [
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
            'map' => [
                'zf-debug-utils/favicon.ico' => __DIR__ . '/../public/favicon.ico',
                'zf-debug-utils/css/bootstrap.min.css' => __DIR__ . '/../public/css/bootstrap.min.css',
                'zf-debug-utils/css/bootstrap-theme.min.css' => __DIR__ . '/../public/css/bootstrap-theme.min.css',
                'zf-debug-utils/css/style.css' => __DIR__ . '/../public/css/style.css',
                'zf-debug-utils/js/bootstrap.min.js' => __DIR__ . '/../public/js/bootstrap.min.js',
                'zf-debug-utils/js/jquery.min.js' => __DIR__ . '/../public/js/jquery.min.js',
            ],
        ],
    ],
];
