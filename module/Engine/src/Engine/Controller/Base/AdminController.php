<?php

namespace Engine\Controller\Base;

use Engine;
use Zend\Mvc\MvcEvent;

class AdminController extends NeedAuthController
{
    public function onDispatch (MvcEvent $e)
    {
        $user = $this->getAuthenticator()->getIdentity();
        if (empty($user) || $user->getType() > 1)
            return $this->redirect()->toRoute('home');

        return parent::onDispatch($e);
    }

}
