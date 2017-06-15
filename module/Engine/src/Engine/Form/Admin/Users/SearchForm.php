<?php

namespace Engine\Form\Admin\Users;

use Zend\Form\Form;
use Engine;
use Engine\Filter\Lk\Edit\PasswordFilter as Filter;

class SearchForm extends Form
{

    public function __construct($repository = null, $currentUser = null)
    {
        parent::__construct('SearchForm');
        $this->setAttribute('method', 'get');
        //$this->setAttribute('class', 'bs-example form-horizontal');

        //$this->setInputFilter(new Filter($repository, $currentUser));

        $this->add([
            'name' => 'id',
            'type' => 'number',
            'options' => [
                'label' => 'ID',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '1',
                'maxlength' => '10',
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
                'label' => 'Логин',
            ],
            'attributes' => [
                'maxlength' => '255',
                'class' => 'form-control'
            ],
        ]);

        $this->add([
            'name' => 'type',
            'type' => 'select',
            'options' => [
                'empty_option' => 'Все',
                'label' => 'Тип учетной записи',
                'value_options' => $this->getArrayUserType(),
            ],
            'attributes' => [
                'class' => 'form-control',
                'multiple' => true
            ],
        ]);
        $this->add([
            'name' => 'resetSearch',
            'type' => 'button',
            'options' => [
                'label' => 'Сбросить',
            ],
            'attributes' => [
                'class' => 'btn btn-default',
            ],
        ]);
        $this->add([
            'name' => 'closeSearch',
            'type' => 'button',
            'options' => [
                'label' => 'Закрыть',
            ],
            'attributes' => [
                'class' => 'btn btn-default',
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'options' => [
                'label' => 'Поиск',
            ],
            'attributes' => [
                'value' => 'search',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    private function getArrayUserType()
    {
        $types = [];
        foreach (Engine\Module::APPLICATION_CONFIG['userType'] as $key => $value) {
            $types[$key] = $value;
        }
        return $types;
    }
}
