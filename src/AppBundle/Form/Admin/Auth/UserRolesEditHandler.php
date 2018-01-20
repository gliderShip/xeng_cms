<?php

namespace AppBundle\Form\Admin\Auth;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Auth\XRole;
use AppBundle\Entity\Auth\XUser;
use AppBundle\Form\Base\FormHandler;
use AppBundle\Form\Base\ParamValidationResult;
use AppBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit role permissions form handler
 */
class UserRolesEditHandler extends FormHandler {
    /** @var XUser $user */
    protected $user;

    /** @var array $roles */
    protected $roles;

    /** @var array $toBeDeleted */
    protected $toBeDeleted;

    /** @var array $toBeAdded */
    protected $toBeAdded;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XUser $user
     * @param array $roles
     */
    public function __construct(ContainerInterface $container, Request $request, XUser $user, $roles) {
        parent::__construct($container,$request);
        $this->user=$user;
        $this->roles=$roles;
        $this->toBeAdded=array();
        $this->toBeDeleted=array();
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        /** @var XUserManager $userManager */
        $userManager = $this->container->get('xeng.user_manager');
        /** @var array $userRolesMap */
        $userRolesMap=$userManager->getUserRolesMap($this->user->getId());

        if($this->isSubmitted()){
            /** @var XRole $role */
            foreach($this->roles as $role){
                $key='role_'.$role->getId();

                /** @var ParamValidationResult $param */
                $param=$this->createParamValidationResult($key);

                $alreadyExists=array_key_exists($key,$userRolesMap);
                $isEmpty=$param->isEmpty();
                //if it is empty but it exists on db, delete it
                if($isEmpty && $alreadyExists){
                    $this->toBeDeleted[]=$userRolesMap[$key];
                }
                //else if it is not empty but not exists on db, add it
                elseif(!$isEmpty && !$alreadyExists){
                    $this->toBeAdded[]=$role;
                }
            }
        } else {
            //it is not submitted yet, just fill in the values according to the existing saved values
            foreach($userRolesMap as $urKey=>$ur){
                $this->createParamValidationResult($urKey)->setValue('on')->setEmpty(false);
            }
        }

    }

    /**
     * @return array
     */
    public function getToBeDeleted(){
        return $this->toBeDeleted;
    }

    /**
     * @return array
     */
    public function getToBeAdded(){
        return $this->toBeAdded;
    }

}
