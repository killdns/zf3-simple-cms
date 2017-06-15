<?php

namespace Engine\Controller\Api;

use Engine\Controller\Base\ApiController;

use Engine\Entity\User;
use Engine\Entity\Repository\UserRepository;
use Zend\Mvc\Controller\ActionController;
use Zend\Authentication\Result as AuthResult;
use Zend\View\Model\JsonModel;
use Engine\Module as Module;
use Engine\Form\Auth\LoginForm;
use Engine\Form\Auth\RegistrationForm;

class AuthController extends ApiController
{
    public function loginAction()
    {

        $messages = [];
        $result = null;

        $repository = $this->getEntityManager()->getRepository(User::class);

        $form = new LoginForm($repository);
        $data = $this->getRequest()->getPost();
        $form->setData($data);


        if ($form->isValid())
        {
            $user = new User();
            $user->setLogin($this->params()->fromPost('login'));
            $user->setPassword($this->params()->fromPost('password'));
            $authResult = $repository->login($user, $this->getServiceLocator());
            if ($authResult->getCode() != AuthResult::SUCCESS)
                array_push($messages, 'Ошибка входа');
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

    }

    public function registrationAction()
    {

        $messages = [];
        $result = null;

        $repository = $this->getEntityManager()->getRepository(User::class);

        $form = new RegistrationForm($repository);
        $data = $this->getRequest()->getPost();
        $form->setData($data);

        if ($form->isValid()) {
            $user = new User();

            $user->setLogin($this->params()->fromPost('login'));
            $user->setPassword($this->params()->fromPost('password'));
            $repository->add($user);

        } else {
            foreach ($form->getInputFilter()->getInvalidInput() as $errors)
                foreach ($errors->getMessages() as $error)
                    array_push($messages, $error);
        }

        $isError = (sizeof($messages) > 0) ? true : false;

        $result = [
            'status' => (!$isError) ? 'success' : 'error',
            'messages' => Module::APPLICATION_CONFIG['showOnlyOneExceptionOnForm'] ? [$messages[sizeof($messages) - 1]] : $messages
        ];

        $result = new JsonModel ($result);
        return $result;
    }
}
