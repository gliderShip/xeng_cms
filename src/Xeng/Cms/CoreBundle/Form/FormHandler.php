<?php

// src/Xeng/Cms/CoreBundle/Form/FormHandler.php

namespace Xeng\Cms\CoreBundle\Form;

use Respect\Validation\Validator;
use Respect\Validation\Validator as v;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

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

    /** @var Validator $notEmptyValidator  */
    protected $notEmpty;

    /** @var boolean $csrfEnabled */
    protected $csrfEnabled;

    /** @var string $csrfTokenId */
    protected $csrfTokenId;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request) {
        $this->notEmpty=v::notEmpty();
        $this->container=$container;
        $this->request=$request;
        $this->validationResponse=new ValidationResponse();
        $this->csrfEnabled=true;
    }

    /**
     * Common parameters
     */
    public function handle(){
        $this->createParamValidationResult('submit');
        $this->handleCsrf();
    }

    public function handleCsrf(){
        if($this->csrfEnabled){
            $user=$this->container->get('security.token_storage')->getToken()->getUser();
            if($user instanceof XUser){
                $this->csrfTokenId='user_'.$user->getId();
            } else {
                $this->csrfTokenId='anon';
            }

            $tokenParam=$this->createParamValidationResult('_token');
            /** @var CsrfTokenManager $tokenManager */
            $tokenManager=$this->container->get('security.csrf.token_manager');
            if($this->isSubmitted()){
                if($tokenParam->isEmpty()){
                    $this->addError($tokenParam,'CSRF invalid, empty');
                } else {
                    $submittedToken=new CsrfToken($this->csrfTokenId,$tokenParam->getStringValue());
                    if(!$tokenManager->isTokenValid($submittedToken)){
                        $this->addError($tokenParam,'CSRF invalid');
                    }

                }
            } else {
                $tokenParam->setValue($tokenManager->getToken($this->csrfTokenId)->getValue());
            }

        }
    }

    /**
     * @return boolean
     */
    public function isSubmitted(){
        return !$this->validationResponse->getParam('submit')->isEmpty();
    }

    /**
     * @return boolean
     */
    public function isCsrfValid(){
        return true;
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

    /**
     * @return boolean
     */
    public function isCsrfEnabled(){
        return $this->csrfEnabled;
    }

    /**
     * @param boolean $csrfEnabled
     */
    public function setCsrfEnabled($csrfEnabled) {
        $this->csrfEnabled = $csrfEnabled;
    }

    /**
     * @param string $csrfTokenId
     */
    public function setCsrfTokenId($csrfTokenId){
        $this->csrfTokenId = $csrfTokenId;
    }


}