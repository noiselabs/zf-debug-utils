<?php
/**
 * ZfDebugModule. WebUI and Console commands for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

use Noiselabs\ZfDebugModule\Factory\Controller\Console\RoutesControllerFactory as ConsoleRoutesControllerFactory;
use Noiselabs\ZfDebugModule\Factory\Controller\Http\IndexControllerFactory;
use Noiselabs\ZfDebugModule\Factory\Controller\Http\RoutesControllerFactory as HttpRoutesControllerFactory;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteCollectionFactory;
use Noiselabs\ZfDebugModule\Factory\Util\Routing\RouteMatcherFactory;
use Noiselabs\ZfDebugModule\Package;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'map' => [
                'zf-debug-utils/favicon.ico' => __DIR__ . '/../public/favicon.ico',
                'zf-debug-utils/css/bootstrap.min.css' => __DIR__ . '/../public/css/bootstrap.min.css',
                'zf-debug-utils/css/bootstrap-theme.min.css' => __DIR__ . '/../public/css/bootstrap-theme.min.css',
                'zf-debug-utils/css/datatables.min.css' => __DIR__ . '/../public/css/datatables.min.css',
                'zf-debug-utils/css/style.css' => __DIR__ . '/../public/css/style.css',
                'zf-debug-utils/fonts/glyphicons-halflings-regular.woff' =>  __DIR__ . '/../public/fonts/glyphicons-halflings-regular.woff',
                'zf-debug-utils/fonts/glyphicons-halflings-regular.woff2' =>  __DIR__ . '/../public/fonts/glyphicons-halflings-regular.woff2',
                'zf-debug-utils/js/bootstrap.min.js' => __DIR__ . '/../public/js/bootstrap.min.js',
                'zf-debug-utils/js/datatables.min.js' => __DIR__ . '/../public/js/datatables.min.js',
                'zf-debug-utils/js/jquery.min.js' => __DIR__ . '/../public/js/jquery.min.js',
                'zf-debug-utils/js/main.js' => __DIR__ . '/../public/js/main.js',
            ],
        ],
    ],
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
                        'may_terminate' => true,
                        'type' => 'literal',
                        'options' => [
                            'route' => '/routes',
                            'defaults' => [
                                'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                                'action' => 'index',
                            ],
                        ],
                        'child_routes' => [
                            'do-match-route' => [
                                'type' => 'literal',
                                'verb' => 'get',
                                'options' => [
                                    'route' => '/match-route',
                                    'defaults' => [
                                        'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                                        'action' => 'matchRoute',
                                    ],
                                ],
                            ],
                            'list' => [
                                'type' => 'literal',
                                'verb' => 'get',
                                'options' => [
                                    'route' => '/list',
                                    'defaults' => [
                                        'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                                        'action' => 'listAll',
                                    ],
                                ],
                            ],
                            'match' => [
                                'type' => 'literal',
                                'verb' => 'get',
                                'options' => [
                                    'route' => '/match',
                                    'defaults' => [
                                        'controller' => HttpRoutesControllerFactory::SERVICE_NAME,
                                        'action' => 'renderMatchRouteView',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            RouteCollectionFactory::SERVICE_NAME => RouteCollectionFactory::class,
            RouteMatcherFactory::SERVICE_NAME => RouteMatcherFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            Package::FQPN . '/index/index' => __DIR__ . '/../views/index/index.phtml',
            Package::FQPN . '/layout' => __DIR__ . '/../views/layout/layout.phtml',
            Package::FQPN . '/routes/list-all' => __DIR__ . '/../views/routes/list-all.phtml',
            Package::FQPN . '/routes/match' => __DIR__ . '/../views/routes/match.phtml',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
