<?php


namespace Engine\Controller\Lk;

use Engine\Controller\Base\NeedAuthController;
use Engine\Layout\Scripts\Navigation;

class IndexController extends NeedAuthController
{
    public function indexAction()
    {

        return ['lkParams' =>
            [
                'user' => $this->getCurrentUser()
            ]
        ];
    }
}
