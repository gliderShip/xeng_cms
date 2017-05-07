<?php

// src/Xeng/Cms/AdminBundle/Form/Account/AccountUserEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Account;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;
use Xeng\Cms\CoreBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create user form handler
 */
class AccountUserEditHandler extends FormHandler {
    /** @var XUser $user */
    protected $user;
    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XUser $user
     */
    public function __construct(ContainerInterface $container, Request $request, XUser $user) {
        parent::__construct($container,$request);
        $this->user=$user;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $username=$this->createParamValidationResult('username');
        $email=$this->createParamValidationResult('email');
        $currentPassword=$this->createParamValidationResult('currentPassword');
        $password=$this->createParamValidationResult('password');
        $repeatPassword=$this->createParamValidationResult('passwordRepeat');
        $this->createParamValidationResult('enabled');

        if(!$this->isSubmitted()){
            $this->validationResponse->setValue('username',$this->user->getUsername());
            $this->validationResponse->setValue('email',$this->user->getEmail());
            $this->validationResponse->setValue('enabled',$this->user->isEnabled());
            return;
        }

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

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->container->get('xeng.user_manager');

        if($this->notEmpty->validate($password->getValue())){
            if(!$this->notEmpty->validate($repeatPassword->getValue())){
                $this->addError($repeatPassword,'Repeat password cannot be empty');
                return;
            }

            if($password->getValue() !== $repeatPassword->getValue()){
                $this->addError($repeatPassword,'Passwords do not match');
                return;
            }

            if(!$this->notEmpty->validate($currentPassword->getValue())){
                $this->addError($currentPassword,'Current password cannot be empty');
                return;
            }

            if(!$xUserManager->isPasswordValid($this->user,$currentPassword->getStringValue())){
                $this->addError($currentPassword,'Password authentication failed');
                return;
            }
        }

        $emailValue=$email->getStringValue();
        if($this->user->getEmail()!==$emailValue && $xUserManager->emailExists($emailValue)){
            $this->addError($email,'Email already exists');
            return;
        }

        $usernameValue=$username->getStringValue();
        if($this->user->getUsername()!==$usernameValue && $xUserManager->usernameExists($usernameValue)){
            $this->addError($username,'Username is already taken');
            return;
        }

    }

}