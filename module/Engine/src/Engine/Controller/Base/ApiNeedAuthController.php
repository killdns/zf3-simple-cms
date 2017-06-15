<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;

class ApiNeedAuthController extends ApiController
{
    public function onDispatch (MvcEvent $e)
    {
        $user = $this->getAuthenticator()->getIdentity();
        if (empty($user))
            return $this->redirect()->toRoute('home', ['action' => 'index']);

        return parent::onDispatch($e);
    }

}
