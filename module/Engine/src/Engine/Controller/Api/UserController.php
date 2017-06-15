<?php

namespace Engine\Controller\Api;

use Engine\Controller\Base\ApiController;

use Engine\Controller\Base\ApiNeedAuthController;
use Engine\Entity\User;
use Zend\Mvc\Controller\ActionController;
use Zend\View\Model\JsonModel;
use Engine\Module as Module;
use Engine\Form\Lk\Edit\PasswordForm;

class UserController extends ApiNeedAuthController
{
    public function changePasswordAction()
    {
        $messages = [];
        $result = null;

        $repository = $this->getEntityManager()->getRepository(User::class);
        $user = $this->getCurrentUser();

        $form = new PasswordForm($repository, $user);
        $data = $this->getRequest()->getPost();
        $form->setData($data);

        if ($form->isValid())
        {
            $user->setPassword($this->params()->fromPost('password'));
            $repository->changePassword($this->getCurrentUser());
        }
        else
        {
            foreach ($form->getInputFilter()->getInvalidInput() as $errors)
                foreach ($errors->getMessages() as $error)
                    array_push($messages, $error);

        }

        $isError = (sizeof($messages) > 0) ? true : false;

        $result = [
            'status'    => (!$isError) ? 'success' : 'error',
            'messages'  => Module::APPLICATION_CONFIG['showOnlyOneExceptionOnForm'] ? [$messages[sizeof($messages) - 1]] : $messages
        ];

        $result = new JsonModel ($result);
        return $result;

        return 'pass';

    }




}
