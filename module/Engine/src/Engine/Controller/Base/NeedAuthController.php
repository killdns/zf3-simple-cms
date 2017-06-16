<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;

class NeedAuthController extends DefaultController
{
    public function onDispatch (MvcEvent $e)
    {
        $user = $this->getAuthenticator()->getIdentity();
        if (empty($user))
            return $this->redirect()->toRoute('auth', ['controller' => 'index', 'action' => 'login']);

        return parent::onDispatch($e);
    }
}
