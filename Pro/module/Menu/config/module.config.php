<?php
namespace Menu;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'menu' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/menu[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MenuController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'menu' => __DIR__ . '/../view',
        ],
    ],
];
