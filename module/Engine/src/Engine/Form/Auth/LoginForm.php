<?php

namespace Engine\Form\Auth;

use Zend\Form\Form;
use Engine\Filter\Auth\LoginFilter as Filter;

class LoginForm extends Form
{

    public function __construct($repository = null)
    {
        parent::__construct('LoginForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new Filter($repository));

        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
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
                'label' => 'Пароль',
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
                'value' => 'Войти',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary',
            ],

        ]);
    }
}
