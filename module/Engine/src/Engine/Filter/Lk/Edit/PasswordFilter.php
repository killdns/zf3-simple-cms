<?php

namespace Engine\Filter\Lk\Edit;

use Engine\Entity\Repository\UserRepository;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;
use Zend\Validator\Regex;
use Zend\Validator\NotEmpty;
use Zend\Validator\Callback;

class PasswordFilter extends InputFilter
{
    protected $repository;
    protected $currentUser;
    public function __construct($repository = null, $currentUser = null)
    {
        $this->repository = $repository;
        $this->currentUser = $currentUser;

        $this->add([
            'name' => 'passwordConfirm',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => [$this, 'validatePassword'],
                        'callbackOptions' => [
                            'password',
                        ],
                        'messages' => [
                            Callback::INVALID_VALUE => "Новый пароль совпадает со старым",
                        ]
                    ]
                ]
            ]
        ]);
        $this->add([
            'name' => 'passwordConfirm',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'password',
                        'messages' => [
                            Identical::NOT_SAME => 'Пароли не совпадают',
                            Identical::MISSING_TOKEN => 'Отсутствует пароль',
                        ]
                    ],
                ],
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => "Повтор пароля не может быть пустым",
                        ]
                    ]
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[\S]+$/',
                        'messages' => [
                            Regex::NOT_MATCH => 'Пароль не должен содержать пробелы',
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 255,
                        'messages' => [
                            StringLength::TOO_SHORT => "Минимальная длина пароля - 6 символов",
                            StringLength::TOO_LONG => "Длина логина должна быть меньше 255 символов",
                        ]
                    ]
                ],
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => "Новый пароль не может быть пустым",
                        ]
                    ]
                ],
            ]
        ]);
        $this->add([
            'name' => 'oldPassword',
            'required' => true,
            'validators' => [

                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => [$this, 'validateOldPassword'],
                        'callbackOptions' => [
                            'password',
                        ],
                        'messages' => [
                            Callback::INVALID_VALUE => "Введен неверный пароль",
                        ]
                    ]
                ],
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => "Старый пароль не может быть пустым",
                        ]
                    ]
                ],
            ]
        ]);


    }

    public function validateOldPassword($value)
    {
        if (empty($this->repository))
            return true;

        if ($this->currentUser->getPassword() == UserRepository::passwordTransform($value))
            return true;
        else
            false;
    }

    public function validatePassword($value)
    {
        if (empty($this->repository))
            return true;

        if ($this->currentUser->getPassword() == UserRepository::passwordTransform($value))
            return false;

        return true;
    }
}