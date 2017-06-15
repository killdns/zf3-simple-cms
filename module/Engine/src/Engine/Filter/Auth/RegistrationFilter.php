<?php

namespace Engine\Filter\Auth;

use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;
use Zend\Validator\Regex;
use Zend\Validator\NotEmpty;
use Engine;
use Engine\Validator\ObjectIsExistValidator;

class RegistrationFilter extends InputFilter
{
    public function __construct($repository = null)
    {
        $this->add([
            'name' => 'passwordConfirm',
            'required' => true,
            'validators' => [
                [
                    'name'    => 'Identical',
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
                            StringLength::TOO_SHORT => "Минимальная длина пароля - %min% символов",
                            StringLength::TOO_LONG => "Длина логина должна быть меньше %max% символов",
                        ]
                    ]
                ],
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
                        'name' => ObjectIsExistValidator::class,
                        'options' => [
                            'skip' => empty($repository) ? true : false,
                            'repository' => $repository,
                            'mode' => 'notExist',
                            'fields' => 'login',
                            'messages' => [
                                ObjectIsExistValidator::EXIST => "Пользователь с таким логином существует",
                            ]
                        ]
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[\w]+$/',
                            'messages' => [
                                Regex::INVALID => 'Ошибка регулярного выражения',
                                Regex::NOT_MATCH => 'Логин должен состоять только из латиницы и цифр',
                                Regex::ERROROUS => 'Внутренняя ошибка'
                            ]
                        ]
                    ],
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 3,
                            'max' => 255,
                            'messages' => [
                                StringLength::TOO_SHORT => "Минимальная длина логина - %min% символа",
                                StringLength::TOO_LONG => "Длина логина должна быть меньше %max% символов",
                            ]
                        ]
                    ],
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
}