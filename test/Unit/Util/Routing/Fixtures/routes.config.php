<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

use Noiselabs\ZfDebugModule\Package;

return [
    Package::NAME => [
        'type' => 'literal',
        'options' => [
            'route' => '/_debug',
            'defaults' => [
                'controller' => 'IndexController',
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
                        'controller' => 'HttpRoutesController',
                    ],
                ],
                'child_routes' => [
                    'do-match-route' => [
                        'type' => 'literal',
                        'verb' => 'get',
                        'options' => [
                            'route' => '/match-route',
                            'defaults' => [
                                'controller' => 'HttpRoutesController',
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
                                'controller' => 'HttpRoutesController',
                                'action' => 'renderMatchRouteView',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
