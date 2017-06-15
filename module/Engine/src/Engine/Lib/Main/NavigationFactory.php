<?php

namespace Engine\Lib\Main;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends  DefaultNavigationFactory
{
    protected  function  getName()
    {
        return 'main_navigation';
    }
}