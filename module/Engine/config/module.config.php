<?php

use Zend\Navigation\Service\DefaultNavigationFactory;

use Engine\Controller\Base\ApiController as BaseApiController;
use Engine\Controller\Main\IndexController as MainIndexController;
use Engine\Controller\Auth\IndexController as AuthIndexController;
use Engine\Controller\Lk\IndexController as LkIndexController;
use Engine\Controller\Lk\EditController as LkEditController;


use Engine\Controller\Admin\IndexController as AdminIndexController;
use Engine\Controller\Admin\UsersController as AdminUsersController;


use Engine\Controller\Api\Admin\UsersController as ApiAdminUsersController;
use Engine\Controller\Api\AuthController as ApiAuthController;
use Engine\Controller\Api\UserController as ApiUserController;

use Engine\Lib\Auth\NavigationFactory as AuthNavigationFactory;
use Engine\Lib\Admin\NavigationFactory as AdminNavigationFactory;
use Engine\Lib\Lk\NavigationFactory as LkNavigationFactory;


use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Engine\Entity\User;
use Engine\Entity\Repository\UserRepository;
return [

    'controllers' => [
        'invokables' => [

            'Engine\Controller\Base\Api'             => BaseApiController::class,

            'Engine\Controller\Index'               => MainIndexController::class,
            'Auth\Controller\Index'                 => AuthIndexController::class,
            'Lk\Controller\Index'                   => LkIndexController::class,
            'Lk\Controller\Edit'                    => LkEditController::class,

            'Admin\Controller\Index'                => AdminIndexController::class,
            'Admin\Controller\Users'                => AdminUsersController::class,

            'Api\Controller\Auth'                   => ApiAuthController::class,
            'Api\Controller\User'                   => ApiUserController::class,
            'Api\Admin\Controller\User'             => ApiAdminUsersController::class,
        ],
    ],

    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
            'factories' => [
                'navigation'                => DefaultNavigationFactory::class,
                'engine_navigation'           => Engine\Lib\Engine\NavigationFactory::class,
                //'main_navigation'           => MainNavigationFactory::class,
                'auth_navigation'           => AuthNavigationFactory::class,
                'admin_navigation'          => AdminNavigationFactory::class,
                'lk_navigation'             => LkNavigationFactory::class,
            ],
    ],
    'view_helpers' => [
        'invokables'=> [
            'navigation_helper' => Engine\View\Helper\NavigationHelper::class
        ]
    ],


    'translator' => [
        'locale' => 'ru_RU',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],

    'router' => require __DIR__ . '/router.config.php',
    'navigation' => require __DIR__ . '/navigation.config.php',

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',

            'engine/controller/main/index/index'                   => __DIR__ . '/../view/engine/main/index/index.phtml',

            'engine/controller/auth/index/login'                   => __DIR__ . '/../view/engine/auth/index/login.phtml',
            'engine/controller/auth/index/registration'            => __DIR__ . '/../view/engine/auth/index/registration.phtml',

            'engine/controller/admin/index/index'                  => __DIR__ . '/../view/engine/admin/index/index.phtml',
            'engine/admin/users/list'                              => __DIR__ . '/../view/engine/admin/users/list.phtml',

            'engine/controller/lk/index/index'                     => __DIR__ . '/../view/engine/lk/index/index.phtml',
            'engine/controller/lk/edit/index'                     => __DIR__ . '/../view/engine/lk/edit/index.phtml',
            'engine/controller/lk/edit/password'                     => __DIR__ . '/../view/engine/lk/edit/password.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'pagination_control' =>
                __DIR__ . '/../view/layout/paginator.phtml'
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],


    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'engine_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Engine/Entity',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Engine\Entity' => 'engine_entity'
                ]
            ]
        ],
        'authentication' => [
            'orm_default' => [
                'identity_class'        => User::class,
                'identity_property'     => 'login',
                'credential_property'   => 'password',
                'credential_callable'   =>
                    function(User $user, $password)
                    {
                        return UserRepository::authCondition($user, $password);
                    }
            ]
        ],
    ],
];