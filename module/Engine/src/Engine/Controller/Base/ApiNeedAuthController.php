<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;

class ApiNeedAuthController extends ApiController
{
    public function onDispatch (MvcEvent $e)
    {
        if (empty($this->user))
            return $this->redirect()->toRoute('home', ['action' => 'index']);

        return parent::onDispatch($e);
    }

}
