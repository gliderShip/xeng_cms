<?php

// src/Xeng/Cms/CoreBundle/Services/Auth/XUserManager.php

namespace Xeng\Cms\CoreBundle\Services\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Auth\XRole;
use Xeng\Cms\CoreBundle\Entity\Auth\XRolePermission;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Entity\Auth\XUserRole;
use Xeng\Cms\CoreBundle\Repository\Auth\XRolePermissionRepository;
use Xeng\Cms\CoreBundle\Repository\Auth\XUserRepository;
use Xeng\Cms\CoreBundle\Repository\Auth\XUserRoleRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XUserManager {
    /** @var UserManagerInterface */
    private $userManager;

    /** @var ObjectManager */
    private $manager;

    /**
     * @param ObjectManager $manager
     * @param UserManagerInterface $userManager
     */
    public function __construct(ObjectManager $manager, UserManagerInterface $userManager) {
        $this->manager = $manager;
        $this->userManager = $userManager;
    }

    /**
     * @param $userId string
     * @return XUser
     */
    public function getUser($userId){
        /** @var XUser $user */
        $user = $this->userManager->findUserBy(['id'=>$userId]);
        return $user;
    }

    /**
     * @param string $username
     * @return boolean
     */
    public function usernameExists($username){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XUser');
        return $repository->usernameExists($username);
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function emailExists($email){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XUser');
        return $repository->emailExists($email);
    }


    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllUsers($currentPage = 1, $pageSize = 30){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XUser');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllUsersQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param boolean $enabled
     */
    public function createUser($username,$email,$password,$enabled){
        /** @var XUser $user */
        $user = $this->userManager->createUser();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled($enabled);

        $this->userManager->updateUser($user);
    }

    /**
     * @param string $userId
     * @param string $username
     * @param string $email
     * @param boolean $enabled
     * @param string $password
     */
    public function updateUser($userId,$username,$email,$enabled,$password=null){
        /** @var XUser $user */
        $user = $this->userManager->findUserBy(['id'=>$userId]);

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled($enabled);
        if($password){
            $user->setPlainPassword($password);
        }
        $this->userManager->updateUser($user);
    }

    /**
     * @param integer $userId
     * @return array user role map
     */
    public function getUserRolesMap($userId){
        /** @var XUserRoleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Auth\XUserRole');
        /** @var array $map */
        $map=array();

        $useRoles = $repository->getUserRoles($userId);
        /** @var XUserRole $ur */
        foreach($useRoles as $ur){
            $map['role_'.$ur->getRole()->getId()]=$ur;
        }

        return $map;
    }

    /**
     * @param array $userRoles
     */
    public function deleteRolePermissions($userRoles){
        /** @var XUserRole $ur */

        foreach($userRoles as $ur){
            $this->manager->remove($ur);
        }

        $this->manager->flush();
    }

    /**
     * @param XUser $user
     * @param array $roles
     */
    public function addUserRoles(XUser $user,$roles){
        /** @var XRole $role */
        foreach($roles as $role){

            /** @var XUserRole $ur */
            $ur=new XUserRole();
            $ur->setUser($user);
            $ur->setRole($role);
            $this->manager->persist($ur);
        }

        $this->manager->flush();
    }

    /**
     * @param integer $userId
     * @return array user role map
     */
    public function getUserPermissionMap($userId){
        /** @var XUserRoleRepository $urRep */
        $urRep = $this->manager->getRepository('XengCmsCoreBundle:Auth\XUserRole');
        /** @var XRolePermissionRepository $rpRep */
        $rpRep = $this->manager->getRepository('XengCmsCoreBundle:Auth\XRolePermission');
        /** @var array $map */
        $map=array();

        $useRoles = $urRep->getUserRoles($userId);
        /** @var XUserRole $ur */
        foreach($useRoles as $ur){
            $rolePermissions=$rpRep->getRolePermissions($ur->getRole()->getId());
            /** @var XRolePermission $rp */
            foreach($rolePermissions as $rp){
                $map[$rp->getModule().'.'.$rp->getPermission()]=true;
            }
        }

        return $map;
    }
}