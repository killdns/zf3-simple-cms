<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;

class NeedAuthController extends DefaultController
{
    public function onDispatch (MvcEvent $e)
    {
        if ($this->getCurrentUser()) {
            return $this->redirect()->toRoute('auth/default', ['controller' => 'index', 'action' => 'login']);
        }
        return parent::onDispatch($e);
    }
}
