<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;

class ApiAdminController extends AdminController
{
    public function onDispatch (MvcEvent $e)
    {
        /*if (!$e->getRequest()->isPost())
            return $this->redirect()->toRoute('home', ['action' => 'index']);*/

        return parent::onDispatch($e);
    }

}
