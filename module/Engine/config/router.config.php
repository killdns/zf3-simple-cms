<?php

use Engine\Controller\Base\ApiController as BaseApiController;
use Engine\Controller\Main\IndexController as MainIndexController;
use Engine\Controller\Auth\IndexController as AuthIndexController;
use Engine\Controller\Lk\IndexController as LkIndexController;
use Engine\Controller\Lk\EditController as LkEditController;
use Engine\Controller\Api\Admin\UsersController as ApiAdminUsersController;

use Engine\Controller\Admin\IndexController as AdminIndexController;
use Engine\Controller\Admin\UsersController as AdminUsersController;

use Engine\Controller\Api\AuthController as ApiAuthController;
use Engine\Controller\Api\UserController as ApiUserController;

return [
// Uncomment below to add routes
    'routes' => [
        'home' => [
            'type' => Literal::class,
            'options' => [
                'route'    => '/',
                'defaults' => [
                    'controller' => MainIndexController::class,
                    'action'     => 'index',
                ],
            ],
        ],
        'engine' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/',
                'defaults' => [
                    'controller' => MainIndexController::class,
                    'action' => 'index',
                ]
            ]
        ],
        'api' => [
            'type' => 'segment',
            'options' => [
                'route' => '/api/',
                'constraints' => [
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                ],
                'defaults' => [
                    'controller' => BaseApiController::class,
                    'action' => 'index',
                ]
            ],
            'may_terminate' => true,
            'child_routes' => [
                'admin' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => 'admin/',
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'users' => [
                            'type' => 'segment',
                            'options' => [
                                'route' => 'users/:action',
                                'constraints' => [
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                                ],
                                'defaults' => [
                                    'controller' => ApiAdminUsersController::class,
                                    'action' => 'index',
                                ]
                            ]
                        ],
                    ]
                ],
                'auth' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => 'auth/:action',
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ],
                        'defaults' => [
                            'controller' => ApiAuthController::class,
                        ]
                    ]
                ],
                'user' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => 'user/:action',
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ],
                        'defaults' => [
                            'controller' => ApiUserController::class,
                        ]
                    ]
                ],
            ],
        ],
        'auth' => [
            'type' => 'literal',
            'options' => [
                'route' => '/auth/',
                'defaults' => [
                    'controller' => AuthIndexController::class,
                    'action' => 'index',
                ]
            ],
            'may_terminate' => true,
            'child_routes' => [
                'login' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => 'login/',
                        'defaults' => [
                            'controller' => AuthIndexController::class,
                            'action'     => 'login',
                        ]
                    ]
                ],
                'registration' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => 'registration/',
                        'defaults' => [
                            'controller' => AuthIndexController::class,
                            'action'     => 'registration',
                        ]
                    ]
                ],
                'logout' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => 'logout/',
                        'defaults' => [
                            'controller' => AuthIndexController::class,
                            'action'     => 'logout',
                        ]
                    ]
                ],
            ]
        ],
        'admin' => [
            'type'    => Literal::class,
            'options' => [
                'route'    => '/admin/',
                'defaults' => [
                    'controller' => AdminIndexController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'users' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => 'users/',
                        'defaults' => [
                            'controller' => AdminIndexController::class,
                            'action'     => 'index',
                        ]
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'list' => [
                            'type' => Literal::class,
                            'options' => [
                                'route' => 'list/',
                                'defaults' => [
                                    'controller' => AdminUsersController::class,
                                    'action'     => 'list',
                                ]
                            ],
                        ],
                        'add' => [
                            'type' => Literal::class,
                            'options' => [
                                'route' => 'add/',
                                'defaults' => [
                                    'controller' => AdminUsersController::class,
                                    'action'     => 'add',
                                ]
                            ]
                        ],
                    ]
                ],
            ],
        ],
        'lk' => [
            'type'    => Literal::class,
            'options' => [
                'route'    => '/lk/',
                'defaults' => [
                    'controller' => LkIndexController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'edit' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => 'edit/',
                        'defaults' => [
                            'controller' => LkEditController::class,
                            'action'     => 'index',
                        ]
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'password' => [
                            'type' => Literal::class,
                            'options' => [
                                'route' => 'password/',
                                'defaults' => [
                                    'controller' => LkEditController::class,
                                    'action'     => 'password',
                                ]
                            ]
                        ],
                    ],
                ],
            ],
        ]
    ],
];