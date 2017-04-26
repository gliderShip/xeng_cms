<?php

// src/Xeng/Cms/CoreBundle/Services/Auth/XUserManager.php

namespace Xeng\Cms\CoreBundle\Services\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Auth\XRole;
use Xeng\Cms\CoreBundle\Entity\Auth\XRolePermission;
use Xeng\Cms\CoreBundle\Repository\Auth\XRolePermissionRepository;
use Xeng\Cms\CoreBundle\Repository\Auth\XRoleRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XRoleManager {

    /** @var ObjectManager */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param $roleId string
     * @return XRole
     */
    public function getRole($roleId){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRole');
        return $repository->getRole($roleId);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function roleNameExists($name){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRole');
        return $repository->roleNameExists($name);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllRoles($currentPage = 1, $pageSize = 30){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRole');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllRolesQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param string $name
     * @param string $description
     * @param boolean $enabled
     */
    public function createRole($name,$description,$enabled){
        /** @var XRole $role */
        $role = new XRole();

        $role->setName($name);
        $role->setDescription($description);
        $role->setEnabled($enabled);

        $this->manager->persist($role);
        $this->manager->flush();
    }

    /**
     * @param integer $roleId
     * @param string $name
     * @param string $description
     * @param boolean $enabled
     */
    public function updateRole($roleId,$name,$description,$enabled){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRole');
        /** @var XRole $role */
        $role = $repository->getRole($roleId);

        $role->setName($name);
        $role->setDescription($description);
        $role->setEnabled($enabled);

        $this->manager->persist($role);
        $this->manager->flush();
    }

    /**
     * @param integer $roleId
     * @return array permission map
     */
    public function getRolePermissionsMap($roleId){
        /** @var XRolePermissionRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRolePermission');
        /** @var array $map */
        $map=array();

        $rolePermissions = $repository->getRolePermissions($roleId);
        /** @var XRolePermission $rp */
        foreach($rolePermissions as $rp){
            $map[$rp->getModule().'.'.$rp->getPermission()]=$rp;
        }

        return $map;
    }

    /**
     * @param array $rolePermissions
     */
    public function deleteRolePermissions($rolePermissions){
        /** @var XRolePermission $rp */

        foreach($rolePermissions as $rp){
            $this->manager->remove($rp);
        }

        $this->manager->flush();
    }

    /**
     * @param XRole $role
     * @param array $rolePermissionKeys
     */
    public function addRolePermissions(XRole $role,$rolePermissionKeys){
        /** @var string $rpk */
        foreach($rolePermissionKeys as $rpk){
            /** @var array $exploded */
            $exploded=explode('.',$rpk,2);
            $moduleId=$exploded[0];
            $permissionId=$exploded[1];
            /** @var XRolePermission $rp */
            $rp=new XRolePermission();
            $rp->setRole($role);
            $rp->setModule($moduleId);
            $rp->setPermission($permissionId);
            $this->manager->persist($rp);
        }

        $this->manager->flush();
    }

}