<?php

namespace Engine\Controller\Api\Admin;

use Engine\Controller\Base\ApiAdminController;

use Engine\Form\Admin\Users\AddForm;
use Engine\Form\Admin\Users\EditForm;
use Engine\Entity\User;
use Zend\Mvc\Controller\ActionController;
use Zend\View\Model\JsonModel;
use Engine\Module as Module;

class UsersController extends ApiAdminController
{
    public function removeAction()
    {
        $messages = [];
        $result = null;

        $repository = $this->getEntityManager()->getRepository(User::class);

        $id = $this->params()->fromPost('id');

        if ($id == null)
            array_push($messages, 'ID не может быть пустым');
        if (!is_int((int)$id))
            array_push($messages, 'ID не является числом');
        if ((int)$id < 0)
            array_push($messages, 'ID не может быть меньше нуля');
        if ($this->user->getId() == (int)$id)
            array_push($messages, 'ID не может совпадать с ID текущего пользователя');
        if (!empty($repository->findEntityByParams(['id' => (int)$id, 'type' => 0])))
            array_push($messages, 'Нельзя удалить главного администратора');


        $isError = (sizeof($messages) > 0) ? true : false;

        if (!$isError)
            $repository->remove($id);

        $result = [
            'status'    => (!$isError) ? 'success' : 'error',
            'messages'  => Module::APPLICATION_CONFIG['showOnlyOneExceptionOnForm'] ? [$messages[sizeof($messages) - 1]] : $messages
        ];

        $result = new JsonModel ($result);
        return $result;
    }

    public function addAction()
    {
        $messages = [];
        $result = null;

        $repository = $this->getEntityManager()->getRepository(User::class);

        $form = new AddForm($repository, $this->user);
        $data = $this->getRequest()->getPost();
        $form->setData($data);
        if ($form->isValid()) {
            $user = new User();

            $user->setType($this->params()->fromPost('type'));
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
