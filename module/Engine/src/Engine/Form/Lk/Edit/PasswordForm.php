<?php

namespace Engine\Form\Lk\Edit;

use Zend\Form\Form;
use Engine\Filter\Lk\Edit\PasswordFilter as Filter;

class PasswordForm extends Form
{

    public function __construct($repository = null, $currentUser = null)
    {
        parent::__construct('PasswordForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new Filter($repository, $currentUser));

        $this->add([
            'name' => 'oldPassword',
            'type' => 'password',
            'options' => [
                'min' => '1',
                'label' => 'Старый пароль',
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
                'label' => 'Новый пароль',
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
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
