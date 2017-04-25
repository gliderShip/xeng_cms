<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/RoleEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Auth\XRole;
use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;
use Xeng\Cms\CoreBundle\Services\Auth\XRoleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit role form handler
 */
class RoleEditHandler extends FormHandler {
    /** @var XRole $role */
    protected $role;
    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XRole $role
     */
    public function __construct(ContainerInterface $container, Request $request, XRole $role) {
        parent::__construct($container,$request);
        $this->role=$role;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $name=$this->createParamValidationResult('name');
        $this->createParamValidationResult('description');
        $this->createParamValidationResult('enabled');

        if(!$this->isSubmitted()){
            $this->validationResponse->setValue('name',$this->role->getName());
            $this->validationResponse->setValue('description',$this->role->getDescription());
            $this->validationResponse->setValue('enabled',$this->role->isEnabled());
            return;
        }

        $nameValidator=v::allOf(
            $this->notEmpty,
            v::alnum()
        );
        if(!$nameValidator->validate($name->getValue())){
            $this->addError($name,'Role name not valid, must me alphanumeric');
            return;
        }

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->container->get('xeng.role_manager');

        $nameValue=$name->getStringValue();
        if($this->role->getName()!==$nameValue && $xRoleManager->roleNameExists($nameValue)){
            $this->addError($name,'Role name is already taken');
            return;
        }

    }

}