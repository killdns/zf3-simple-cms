<?php

namespace Engine\Form\Admin\Users;

use Engine;
use Zend\Form\Form;
use Engine\Filter\Admin\Users\AddFilter as Filter;

class AddForm extends Form
{

    protected $user;
    public function __construct($repository = null, $user = null)
    {
        $this->user = $user;
        parent::__construct('AddUserForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new Filter($repository));

        $this->add([
            'name' => 'type',
            'type' => 'select',
            'options' => [
                'label' => 'Тип учетной записи',
                'value_options' => $this->getArrayUserType(),
            ],
            'attributes' => [
                'value' => 1,
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
                'min' => '1',
                'label' => 'Логин',
            ],
            'attributes' => [
                'maxlength' => '255',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'min' => '255',
                'label' => 'Пароль',
            ],
            'attributes' => [
                'maxlength' => '255',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'passwordConfirm',
            'type' => 'password',
            'options' => [
                'min' => '255',
                'label' => 'Повторите',
            ],
            'attributes' => [
                'maxlength' => '255',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Добавить',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary ',
            ],
        ]);
    }
    private function getArrayUserType()
    {
        $types = [];
        foreach (Engine\Module::APPLICATION_CONFIG['userType'] as $key => $value) {
            switch ($this->user->getType())
            {
                case 0:
                    if ($key != 0) $types[$key] = $value;
                    break;
                case 1:
                    if ($key > 1) $types[$key] = $value;
                    break;
            }
        }
        return $types;
    }
}
