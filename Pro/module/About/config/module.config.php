<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace About;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'history' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/history',
                    'defaults' => [
                        'controller' => Controller\AboutController::class,
                        'action'     => 'history',
                    ],
                ],
            ],
            'howto' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/howto',
                    'defaults' => [
                        'controller' => Controller\AboutController::class,
                        'action'     => 'howto',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AboutController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'about' => __DIR__ . '/../view',
        ],
    ],
];
