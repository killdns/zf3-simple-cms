<?php

namespace Engine\Lib\Lk;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends  DefaultNavigationFactory
{
    protected  function  getName()
    {
        return 'lk_navigation';
    }
}