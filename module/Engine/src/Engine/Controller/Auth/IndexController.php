<?php

namespace Engine\Controller\Auth;

use Engine\Controller\Base\DefaultController;

use Engine\Entity\User;
use Engine\Form\Auth\LoginForm;
use Engine\Form\Auth\RegistrationForm;
use Zend\Mvc\Controller\ActionController;
use Zend\Session\SessionManager as SessionManager;

class IndexController extends DefaultController
{
    public function indexAction()
    {
        return $this->redirect()->toRoute('auth/login', ['action' => 'login']);
    }

    public function loginAction()
    {
        if (!empty($this->getCurrentUser()))
            return $this->redirect()->toRoute('lk');
        return ['form' => new LoginForm()];
    }


    public function logoutAction()
    {
        $auth = $this->getAuthenticator();
        $auth->clearIdentity();
        $sessionManager = new SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute('auth/login', ['action' => 'login']);
    }

    public function registrationAction()
    {
        if (!empty($this->getCurrentUser()))
            return $this->redirect()->toRoute('lk');
        return ['form' => new RegistrationForm()];
     }
}
