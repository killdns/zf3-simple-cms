<?php

namespace Engine\Controller\Lk;

use Engine\Controller\Base\NeedAuthController;
use Engine\Form\Lk\Edit\PasswordForm;

class EditController extends NeedAuthController
{
    public function indexAction()
    {

    }

    public function passwordAction()
    {
        $form = new PasswordForm();
        $form->setAttribute('action', $this->url()->fromRoute('lk/edit/password'));
        return ['form' => $form];
    }
}
