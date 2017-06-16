<?php

namespace Engine\Controller\Base;

use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ApiController extends DefaultController
{
    public function onDispatch (MvcEvent $e)
    {
        if ($this->checkError($e)) {
            return;
        }
        else {
            $e->setViewModel( new JsonModel ([]));
        }


        $e->setViewModel( new JsonModel ([]));
        $e->getViewModel()->clearVariables();
        $this->checkPostRequest($e);

        if ($this->checkError($e))
            return;

        return parent::onDispatch($e);
    }


    public function onDispatchCallback(MvcEvent $e)
    {
        $this->checkPostRequest($e);
    }

    private function checkPostRequest(MvcEvent $e)
    {
        if (!$e->getRequest()->isPost()){
            $result = [
                'status'    => 'error',
                'messages'  => ['Wrong request method']
            ];
            $e->getViewModel()->setVariables($result);
        }
    }

    public function isRoot()
    {
        return true;
    }

    public function checkError(MvcEvent $e)
    {
        return $e->getViewModel()->getVariable('status') == 'error';
    }

}
