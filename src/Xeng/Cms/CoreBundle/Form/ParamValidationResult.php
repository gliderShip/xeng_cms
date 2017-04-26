<?php

// src/Xeng/Cms/CoreBundle/Form/ParamValidationResult.php

namespace Xeng\Cms\CoreBundle\Form;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the validation result object for a single field
 */
class ParamValidationResult {

    /** @var string */
    private $name;

    /** @var mixed */
    private $value;

    /** @var boolean */
    private $valid;

    /** @var boolean */
    private $empty;

    /** @var array */
    private $errors;

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @param string $message
     */
    public function addError($message) {
        $this->valid=false;
        $this->errors[]=$message;
    }

    /**
     * @param $name string
     * @param $value mixed
     */
    public function __construct($name,$value) {
        $this->name=$name;
        $this->value=$value;
        $this->valid=true;
        $this->errors = array();
        $this->empty=true;
    }

    /**
     * @return bool
     */
    public function exists() {
        return $this->value!=null;
    }

    /**
     * @return bool
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid($valid) {
        $this->valid = $valid;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getBooleanValue() {
        return !!$this->value;
    }

    /**
     * Returns empty string if value is null
     * @return string
     */
    public function getStringValue() {
        if($this->value!=null){
            return ''.$this->value;
        } else {
            return '';
        }
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        return $this->empty;
    }

    /**
     * @param bool $empty
     */
    public function setEmpty($empty){
        $this->empty = $empty;
    }


}