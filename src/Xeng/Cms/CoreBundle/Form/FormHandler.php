<?php

// src/Xeng/Cms/CoreBundle/Form/FormHandler.php

namespace Xeng\Cms\CoreBundle\Form;

use Respect\Validation\Validator;
use Respect\Validation\Validator as v;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the base class to use as a form handler
 */
class FormHandler {

    /** @var Request $request */
    protected $request;

    /** @var ContainerInterface $container */
    protected $container;

    /** @var ValidationResponse $validationResponse */
    protected $validationResponse;

    /** @var $notEmptyValidator Validator */
    protected $notEmpty;
    /**
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request) {
        $this->notEmpty=v::notEmpty();
        $this->container=$container;
        $this->request=$request;
        $this->validationResponse=new ValidationResponse();
    }

    /**
     * Common parameters
     */
    public function handle(){
        $this->createParamValidationResult('submit');
    }

    /**
     * @return mixed
     */
    public function isSubmitted(){
        return !$this->validationResponse->getParam('submit')->isEmpty();
    }

    /**
     * @return bool
     */
    public function isValid(){
        return $this->validationResponse->isValid();
    }

    /**
     *
     * @param $paramName string
     * @return mixed
     */
    public function get($paramName){
        if($this->request->request->has($paramName)){
            return $this->request->request->get($paramName);
        } else if($this->request->query->has($paramName)){
            return $this->request->query->get($paramName);
        } else {
            return null;
        }
    }

    /**
     *
     * @param $paramName string
     * @return ParamValidationResult
     */
    public function createParamValidationResult($paramName){
        /** @var ParamValidationResult $param */
        $param = new ParamValidationResult($paramName,$this->get($paramName));
        $param->setEmpty(!$this->notEmpty->validate($param->getValue()));
        $this->validationResponse->addParam($param);
        return $param;
    }

    /**
     *
     * @param $param ParamValidationResult
     * @param $message
     */
    public function addError($param,$message){
        $param->addError($message);
        $this->validationResponse->setValid(false);
    }

    /**
     * @return ValidationResponse
     */
    public function getValidationResponse(){
        return $this->validationResponse;
    }


}