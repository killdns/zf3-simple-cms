<?php

namespace Engine\Filter\Auth;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Callback;
use Engine\Entity\User;

class LoginFilter extends InputFilter
{
    protected $repository;
    public function __construct($repository = null)
    {
        $this->repository = $repository;

        $this->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => [$this, 'validateAuth'],
                        'callbackOptions' => [
                            'login',
                        ],
                        'messages' => [
                            Callback::INVALID_VALUE => "Пользователь не найден",
                        ]
                    ]
                ]
            ]
        ]);
        $this->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => "Пароль не может быть пустым",
                        ]
                    ]
                ],
            ]
        ]);
        $this->add([
            'name' => 'login',
            'required' => true,
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => "Логин не может быть пустым",
                        ]
                    ]
                ],
            ]
        ]);

    }

    public function validateAuth($value, $data)
    {
        if (empty($this->repository))
            return true;
        $user = new User();
        $user->setLogin($data['login']);
        $user->setPassword($data['password']);
        return $this->repository->isValidAuthData($user);
    }
}