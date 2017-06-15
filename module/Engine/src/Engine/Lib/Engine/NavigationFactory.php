<?php

namespace Engine\Lib\Engine;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends  DefaultNavigationFactory
{
    protected  function  getName()
    {
        return 'engine_navigation';
    }
}