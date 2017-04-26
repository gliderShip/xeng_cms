<?php

// src/Xeng/Cms/CoreBundle/Form/ValidationResponse.php

namespace Xeng\Cms\CoreBundle\Form;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the validator response object,
 * it contains for each validated field, its value (if there is one),
 * it's validation result and eventual validation errors (multiple per field)
 * It is the Validator implementation responsability to read parameter values from the request
 * validate them and fill in this value object with all the values and validation results
 *
 */
class ValidationResponse {

    /** @var array of ParamValidationResult */
    private $params;

    /** @var boolean */
    private $valid;


    /**
     * @param ParamValidationResult $param
     */
    public function addParam(ParamValidationResult $param) {
        if(!$param->isValid()){
            $this->valid=false;
        }

        $this->params[$param->getName()] = $param;
    }

    /**
     * Returns an associative array with the fields that have validation errors
     * @return array
     */
    public function getErrors() {
        /** @var array $errors */
        $errors=array();

        /** @var ParamValidationResult $param */
        foreach($this->params as $param){
            if(!$param->isValid()){
                foreach ($param->getErrors() as $error){
                    $errors[]=$error;
                }
            }
        }

        return $errors;
    }

    /**
     * Initializes internal array
     */
    public function __construct() {
        $this->valid = true;
        $this->params = array();
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param $name
     * @return ParamValidationResult
     */
    public function getParam($name) {
        if(isset($this->params[$name])){
            return $this->params[$name];
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @return boolean
     */
    public function hasParam($name) {
        return isset($this->params[$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getValue($name) {
        $param=$this->getParam($name);
        if($param!==null){
            return $param->getValue();
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function setValue($name,$value) {
        $param=$this->getParam($name);
        if($param!==null){
            $param->setValue($value);
        }
    }


    /**
     * @param $name
     * @return mixed
     */
    public function getBooleanValue($name) {
        $param=$this->getParam($name);
        if($param!==null){
            return $this->getParam($name)->getBooleanValue();
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getStringValue($name) {
        $param=$this->getParam($name);
        if($param!==null){
            return $this->getParam($name)->getStringValue();
        } else {
            return '';
        }
    }

    /**
     * @param $name
     * @return boolean
     */
    public function isEmpty($name) {
        $param=$this->getParam($name);
        if($param!==null){
            return $this->getParam($name)->isEmpty();
        } else {
            return true;
        }
    }

    /**
     * @param $name
     * @return boolean
     */
    public function hasError($name) {
        $param=$this->getParam($name);
        if($param!==null){
            return !$this->getParam($name)->isValid();
        } else {
            return false;
        }
    }


    /**
     * @param array $params
     */
    public function setParams($params) {
        $this->params = $params;
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


}