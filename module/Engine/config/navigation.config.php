<?php

use Engine\Controller\Main\IndexController as MainIndexController;
use Engine\Controller\Auth\IndexController as AuthIndexController;
use Engine\Controller\Admin\IndexController as AdminIndexController;
use Engine\Controller\Admin\UsersController as AdminUsersController;
use Engine\Controller\Lk\IndexController as LkIndexController;
use Engine\Controller\Lk\EditController as LkEditController;

return [
    'engine_navigation' => [
        [
            'label' => 'Главная страница',
            'route' => 'engine',
            'action' => 'index',
            'resource' => MainIndexController::class,
            'disableNavigation' => true,
        ]
    ],
    'auth_navigation' => [
        [
            'label' => 'Вход и Регистрация',
            'route' => 'auth',
            'action' => 'index',
            'resource' => AuthIndexController::class,
            'isRoot' => true,
            'disableNavigation' => true,
            'pages' => [
                [
                    'label' => 'Вход',
                    'route' => 'auth/login',
                    'action' => 'login',
                    'disableNavigation' => true,
                    'visible' => 1
                ],
                [
                    'label' => 'Регистрация',
                    'route' => 'auth/registration',
                    'action' => 'registration',
                    'disableNavigation' => true,
                    'visible' => 1,
                ],
                [
                    'label' => 'Выход',
                    'route' => 'auth/logout',
                    'action' => 'logout',
                    'disableNavigation' => true,
                    'visible' => 1,
                ]
            ]

        ]
    ],
    'admin_navigation' => [
        [
            'label' => 'Панель управления',
            'route' => 'admin',
            'action' => 'index',
            'resource' => AdminIndexController::class,
            'isRoot' => true,
            'pages' => [
                [
                    'label' => 'Управление пользователями',
                    'description' => "Здесь Вы можете просмотреть список пользователей, создать нового пользователя или изменить существующего",
                    'resource' => AdminUsersController::class,
                    'route' => 'admin/users',
                    'action' => 'index',
                    'visible' => 1,
                    'pages' => [
                        [
                            'label' => 'Список пользователей',
                            'description' => "Здесь Вы можете просмотреть список зарегистрированных пользователей",
                            'route' => 'admin/users/list',
                            'action' => 'list',
                            'visible' => 1,
                        ],
                        [
                            'label' => 'Добавление пользователя',
                            'description' => "Здесь Вы можете добавить нового пользователя",
                            'route' => 'admin/users/add',
                            'action' => 'add',
                            'visible' => 1,
                        ]
                    ]
                ]
            ]

        ]
    ],
    'lk_navigation' => [
        [
            'label' => 'Личный кабинет',
            'route' => 'lk',
            'action' => 'index',
            'resource' => LkIndexController::class,
            'isRoot' => true,
            'pages' => [
                [
                    'label' => 'Редактирование профиля',
                    'route' => 'lk/edit',
                    'action' => 'index',
                    'resource' => LkEditController::class,
                    'description' => 'Здесь Вы сможете сменить некоторые настройки профиля',
                    'panel_style' => 'primary',
                    'visible' => 1,
                    'pages' => [
                        [
                            'label' => 'Изменение пароля',
                            'route' => 'lk/edit/password',
                            'action' => 'password',
                            'description' => "Здесь можно сменить пароль",
                            'panel_style' => 'primary',
                            'visible' => 1,
                        ],
                    ]
                ],
            ]
        ]
    ],
];