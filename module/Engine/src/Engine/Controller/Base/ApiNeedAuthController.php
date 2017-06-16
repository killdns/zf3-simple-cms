<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ApiNeedAuthController extends ApiController
{
    public function onDispatch (MvcEvent $e)
    {
        if ($this->checkError($e)) {
            return parent::onDispatch($e);
        }
        else {
            $e->setViewModel( new JsonModel ([]));
        }

        parent::onDispatchCallback($e);

        if ($this->checkError($e))
            return parent::onDispatch($e);

        $e->setViewModel( new JsonModel ([]));
        $e->getViewModel()->clearVariables();
        $this->hasAuth($e);

        if ($this->checkError($e))
            return;

        return parent::onDispatch($e);
    }

    public function onDispatchCallback(MvcEvent $e)
    {
        if (!parent::isRoot())
        {
            parent::onDispatchCallback($e);
            $this->checkError($e);
        }
        $this->hasAuth($e);
    }

    private function hasAuth(MvcEvent $e)
    {
        $user = $this->getAuthenticator()->getIdentity();
        if (empty($user)) {
            $result = [
                'status' => 'error',
                'messages' => ['Access denied']
            ];
            $e->getViewModel()->setVariables($result);
        }
    }

    public function isRoot()
    {
        return false;
    }

}
