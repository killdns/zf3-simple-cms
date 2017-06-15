<?php

namespace Engine\Controller\Base;

use Doctrine\ORM\EntityManager;
use Engine\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class DefaultController extends AbstractActionController
{
    protected $entityManager;
    protected $authenticator;
    protected $user;
    protected $navigation;

    public function onDispatch (MvcEvent $e)
    {
        $this->setEntityManager($this->getServiceLocator()->get(EntityManager::class));
        $this->setAuthenticator($this->getCurrentAuthenticator());
        $this->setCurrentUser($this->authenticator->getIdentity());

        $this->layout()->setVariables(
            [
                'user' => $this->getCurrentUser(),
                'navigation' => $this->getNavigation()
            ]
        );
        return parent::onDispatch($e);
    }

    public function setEntityManager (EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function getEntityManager ()
    {
        return $this->entityManager;
    }
    public function setAuthenticator (AuthenticationService $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    public function getAuthenticator ()
    {
        return $this->getServiceLocator()->get(AuthenticationService::class);
    }
    private function setCurrentUser (User $user = null)
    {
        $this->user = $user;
    }
    public function getCurrentUser ()
    {
        return $this->user;
    }
    private function setNavigation (Navigation $navigation)
    {
        $this->navigation = $navigation;
    }
    public function getNavigation ()
    {
        return $this->navigation;
    }
    public function getCurrentAuthenticator ()
    {
        return $this->getServiceLocator()->get(AuthenticationService::class);
    }
    public function getServiceLocator ()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
