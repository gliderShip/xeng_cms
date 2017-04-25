<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/UserCreateHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;
use Xeng\Cms\CoreBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create user form handler
 */
class UserCreateHandler extends FormHandler {

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        if(!$this->isSubmitted()){
            return;
        }
        $username=$this->createParamValidationResult('username');
        $email=$this->createParamValidationResult('email');
        $password=$this->createParamValidationResult('password');
        $repeatPassword=$this->createParamValidationResult('passwordRepeat');
        $this->createParamValidationResult('enabled');

        $usernameValidator=v::allOf(
            $this->notEmpty,
            v::alnum('.-_@')
        );
        if(!$usernameValidator->validate($username->getValue())){
            $this->addError($username,'Username not valid');
            return;
        }

        $emailValidator=v::email();
        if(!$emailValidator->validate($email->getValue())){
            $this->addError($email,'Email not valid');
            return;
        }

        if(!$this->notEmpty->validate($password->getValue())){
            $this->addError($password,'Password cannot be empty');
            return;
        }

        if(!$this->notEmpty->validate($repeatPassword->getValue())){
            $this->addError($repeatPassword,'Repeat password cannot be empty');
            return;
        }

        if($password->getValue() !== $repeatPassword->getValue()){
            $this->addError($repeatPassword,'Passwords do not match');
            return;
        }

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->container->get('xeng.user_manager');

        if($xUserManager->emailExists($email->getValue())){
            $this->addError($email,'Email already exists');
            return;
        }

        if($xUserManager->usernameExists($username->getValue())){
            $this->addError($username,'Username is already taken');
            return;
        }

    }
}