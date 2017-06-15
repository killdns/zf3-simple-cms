<?php

namespace Engine\Lib\Auth;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends  DefaultNavigationFactory
{
    protected  function  getName()
    {
        return 'auth_navigation';
    }
}