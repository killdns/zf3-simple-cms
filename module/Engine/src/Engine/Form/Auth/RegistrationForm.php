<?php

namespace Engine\Form\Auth;

use Zend\Form\Form;
use Engine\Filter\Auth\RegistrationFilter as Filter;

class RegistrationForm extends Form
{

    public function __construct($repository = null)
    {
        parent::__construct('RegistrationForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new Filter($repository));

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
                'value' => 'Зарегестрироваться',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary ',
            ],
        ]);
    }
}
