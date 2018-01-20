<?php

namespace AppBundle\Services\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Doctrine\PaginatedResult;
use AppBundle\Doctrine\PaginatorUtil;
use AppBundle\Entity\Auth\XRole;
use AppBundle\Entity\Auth\XRolePermission;
use AppBundle\Repository\Auth\XRolePermissionRepository;
use AppBundle\Repository\Auth\XRoleRepository;
use AppBundle\Util\ParameterUtils;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\QueryException;

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
     * @throws NonUniqueResultException
     */
    public function getRole($roleId){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XRole');
        return $repository->getRole($roleId);
    }

    /**
     * @param string $name
     * @return boolean
     * @throws QueryException
     */
    public function roleNameExists($name){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XRole');
        return $repository->roleNameExists($name);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllRoles($currentPage = 1, $pageSize = 30){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XRole');
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
     * @throws NonUniqueResultException
     */
    public function updateRole($roleId,$name,$description,$enabled){
        /** @var XRoleRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XRole');
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
        $repository = $this->manager->getRepository('AppBundle:Auth\XRolePermission');
        /** @var array $map */
        $map=array();

        $rolePermissions = $repository->getRolePermissions($roleId);
        /** @var XRolePermission $rp */
        foreach($rolePermissions as $rp){
            $map[ParameterUtils::encodePeriods($rp->getModule().'.'.$rp->getPermission())]=$rp;
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
        /** @var string $rpke */
        foreach($rolePermissionKeys as $rpke){
            /** @var string $rpk */
            $rpk=ParameterUtils::decodePeriods($rpke);
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
