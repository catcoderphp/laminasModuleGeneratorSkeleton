<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

$factories = new Factories();
$config = [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'api' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '[/:controller][/:id][/:params]',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'params' => ''
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => $factories->getControllers()
    ],
    'service_manager' => [
        "factories" => $factories->getServiceManager()
    ],
    'view_manager' => [ //Add this config
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ]
];
return $config;
