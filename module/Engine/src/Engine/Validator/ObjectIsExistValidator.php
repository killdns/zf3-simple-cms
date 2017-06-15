<?php

namespace Engine\Validator;

use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\AbstractValidator;
use Zend\Mvc\Exception;
use \Doctrine\Common\Persistence\ObjectRepository as ObjectRepositoryClass;

class ObjectIsExistValidator extends AbstractValidator
{
    const INVALID = 'objectIsExistInvalid';
    const EXIST = 'objectIsExistTrue';
    const NOTEXIST = 'objectIsExistFalse';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "Invalid type given. String, integer or float expected",
        self::EXIST => "The object is exist",
        self::NOTEXIST => "The object is not exist"
    ];

    /**
     * @var array
     */
    protected $messageVariables = [
        'mode' => ['options' => 'mode'],
        'fields' => ['options' => 'fields']
    ];

    protected $options = [
        'repository' => null,       // ObjectRepository
        'mode' => 'exist',          // Mode
        'fields' => [],             // Fields for check
        'skip' => false,            // if true - skip this validator (result = true always)
    ];
    /**
     * Sets validator data
     *
     * @param  array $options
     * @throws Exception\InvalidArgumentException if options is invalid
     * @throws Exception\InvalidArgumentException On missing 'repository' parameter
     */
    public function __construct($options = [])
    {
        if (!is_array($options)) {
            throw new Exception\InvalidArgumentException('Invalid options provided to constructor');
        }

        if (!$options['skip']) {

            if (!array_key_exists('repository', $options)) {
                throw new Exception\InvalidArgumentException("Missing option 'repository'");
            }

            $this->setRepository($options['repository']);
            unset($options['repository']);
        }
        parent::__construct($options);
    }
    /**
     * Returns the repository option
     *
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->options['repository'];
    }

    /**
     * Sets the repository option
     *
     * @param  ObjectRepository $repository
     * @throws Exception\InvalidArgumentException if repository option is invalid
     */
    public function setRepository($repository)
    {

        if (!$this->getSkip()) {
            if (!($repository instanceof ObjectRepositoryClass))
                throw new Exception\InvalidArgumentException("Invalid option value 'repository'");

            if (empty($repository))
                throw new Exception\InvalidArgumentException("Option 'repository' cant be a null");
        }

        $this->options['repository'] = $repository;
    }

    /**
     * Returns the mode option
     *
     * @return string
     */
    public function getMode()
    {
        return $this->options['mode'];
    }

    /**
     * Sets the mode option
     *
     * @param  string $mode
     * @throws Exception\InvalidArgumentException if mode option is invalid
     */
    public function setMode($mode)
    {

        if (!is_string($mode))
            throw new Exception\InvalidArgumentException("Invalid option value 'mode'");

        if (empty($mode))
            throw new Exception\InvalidArgumentException("Option 'mode' cant be a null");

        $mode = strtolower($mode);

        if ($mode != 'exist' && $mode != 'notexist')
            throw new Exception\InvalidArgumentException("Option 'mode' can be only 'Exist' or 'NotExist'");

        $this->options['mode'] = strtolower($mode);
    }

    /**
     * Returns the fields option
     *
     * @return array
     */
    public function getFields()
    {
        return $this->options['fields'];
    }

    /**
     * Sets the fields option
     *
     * @param  string|array $fields
     * @throws Exception\InvalidArgumentException if fields option is invalid
     */
    public function setFields($fields)
    {

        if (!is_array($fields) && !is_string($fields))
            throw new Exception\InvalidArgumentException("Invalid option value 'fields'");

        if (empty($fields))
            throw new Exception\InvalidArgumentException("Option 'fields' cant be a null");


        $this->options['fields'] = is_string($fields) ? [$fields] : $fields;
    }
    /**
     * Returns the skip option
     *
     * @return bool
     */
    public function getSkip()
    {
        return $this->options['skip'];
    }

    /**
     * Sets the mode option
     *
     * @param  bool $skip
     * @throws Exception\InvalidArgumentException if skip option is invalid
     */
    public function setSkip($skip)
    {

        if (!is_bool($skip))
            throw new Exception\InvalidArgumentException("Invalid option value 'skip'");



        $this->options['skip'] = strtolower($skip);
    }
    /**
     * Returns validator result
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if ($this->getSkip())
            return true;

        if (!is_string($value)) {
            $this->error(self::INVALID);
            return false;
        }

        $validator = new ObjectExists(array(
            'object_repository' => $this->options['repository'],
            'fields' => $this->options['fields']
        ));


        if ($this->getMode() == 'exist' && !$validator->isValid($value)) {
            $this->error(self::NOTEXIST);
            return false;
        }
        if ($this->getMode() == 'notexist' && $validator->isValid($value)) {
            $this->error(self::EXIST);
            return false;
        }

        return true;
    }
}