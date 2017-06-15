<?php

namespace Engine\Lib\Admin;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends  DefaultNavigationFactory
{
    protected  function  getName()
    {
        return 'admin_navigation';
    }
}