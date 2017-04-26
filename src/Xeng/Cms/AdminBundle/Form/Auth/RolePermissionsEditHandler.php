<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/RolePermissionsEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;
use Xeng\Cms\CoreBundle\Entity\Auth\XPermission;
use Xeng\Cms\CoreBundle\Entity\Auth\XRole;
use Xeng\Cms\CoreBundle\Form\FormHandler;
use Xeng\Cms\CoreBundle\Form\ParamValidationResult;
use Xeng\Cms\CoreBundle\Services\Auth\PermissionManager;
use Xeng\Cms\CoreBundle\Services\Auth\XRoleManager;
use Xeng\Cms\CoreBundle\Util\MemoryLogger;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit role permissions form handler
 */
class RolePermissionsEditHandler extends FormHandler {
    /** @var XRole $role */
    protected $role;

    /** @var array $toBeDeleted */
    protected $toBeDeleted;

    /** @var array $toBeAdded */
    protected $toBeAdded;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XRole $role
     */
    public function __construct(ContainerInterface $container, Request $request, XRole $role) {
        parent::__construct($container,$request);
        $this->role=$role;
        $this->toBeAdded=array();
        $this->toBeDeleted=array();
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        /** @var PermissionManager $permissionManager */
        $permissionManager = $this->container->get('xeng.permission_manager');
        /** @var array $permissionModules */
        $permissionModules = $permissionManager->getModules();

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->container->get('xeng.role_manager');
        /** @var array $permissionMap */
        $permissionMap = $xRoleManager->getRolePermissionsMap($this->role->getId());
        MemoryLogger::log($permissionMap);
        if($this->isSubmitted()){

            /** @var XAppModule $permissionModuleConfig */
            foreach($permissionModules as $permissionModuleConfig){
                /** @var XPermission $permissionConfig */
                foreach($permissionModuleConfig->getChildren() as $permissionConfig){
                    if(!$permissionConfig->isAbstract()){
                        $key=$permissionModuleConfig->getId().'.'.$permissionConfig->getFullId();
                        /** @var ParamValidationResult $param */
                        $param=$this->createParamValidationResult($key);
                        MemoryLogger::log($param);
                        $isEmpty=$param->isEmpty();
                        $isSet=(!!isset($permissionMap[$key]));
                        MemoryLogger::log($key.'->isEmpty: '.$isEmpty);
                        MemoryLogger::log($key.'->isSet: '.$isSet);

                        //if it is empty but it exists on db, delete it
                        if($param->isEmpty() && isset($permissionMap[$key])){
                            $this->toBeDeleted[]=$permissionMap[$key];
                        }
                        //else if it is not empty but not exists on db, add it
                        elseif(!$param->isEmpty() && !isset($permissionMap[$key])){
                            $this->toBeAdded[]=$key;
                        }
                    }
                }
            }

        } else {
            //it is not submitted yet, just fill in the values according to the existing saved values
            foreach($permissionMap as $rpKey=>$rp){
                $this->createParamValidationResult($rpKey)->setValue('on')->setEmpty(false);
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