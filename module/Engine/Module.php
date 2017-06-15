<?php

namespace Engine;

use Zend\ModuleManager\Feature\ValidatorProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Loader\StandardAutoloader;
use Engine\View\Helper\NavigationHelper;
use Engine\Entity\User;
use Doctrine\ORM\EntityManager;
use Engine\Validator\ObjectIsExist;
use Zend\Validator\ValidatorPluginManager;
use DoctrineModule\Validator\ObjectExists;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    const VERSION = '1.0';
    const APPLICATION_NAME = 'ZF Skeleton Application';
    const APPLICATION_LOGO_URL = '/img/zf-logo-mark.svg';
    const APPLICATION_FOOTER_INFO = '<p>&copy; 2005 - 2017 by Zend Technologies Ltd. All rights reserved.</p>';
    const APPLICATION_CONFIG =
        [
            'showOnlyOneExceptionOnForm' => true,
            'userType' => [
                0 => 'Главный администратор',
                1 => 'Администратор',
                2 => 'Пользователь',
            ]
        ];

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    // Autoload all classes from namespace 'Engine' from '/module/Engine/src/Engine'
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ]
            ]
        ];
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                AuthenticationService::class => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
                'viewHelper' => function() {
                    return new NavigationHelper();
                }
            ],
        ];
    }

}