<?php

namespace AppBundle\Services\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query\QueryException;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use AppBundle\Doctrine\PaginatedResult;
use AppBundle\Doctrine\PaginatorUtil;
use AppBundle\Entity\Auth\XRole;
use AppBundle\Entity\Auth\XRolePermission;
use AppBundle\Entity\Auth\XUser;
use AppBundle\Entity\Auth\XUserRole;
use AppBundle\Repository\Auth\XRolePermissionRepository;
use AppBundle\Repository\Auth\XUserRepository;
use AppBundle\Repository\Auth\XUserRoleRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XUserManager {
    /** @var UserManagerInterface $userManager*/
    private $userManager;

    /** @var ObjectManager $manager */
    private $manager;

    /** @var EncoderFactoryInterface $encoderFactory*/
    private $encoderFactory;


    /**
     * @param ObjectManager $manager
     * @param UserManagerInterface $userManager
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        ObjectManager $manager,
        UserManagerInterface $userManager,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->manager = $manager;
        $this->userManager = $userManager;
        $this->encoderFactory = $encoderFactory;
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
     * @throws QueryException
     */
    public function usernameExists($username){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XUser');
        return $repository->usernameExists($username);
    }

    /**
     * @param string $email
     * @return boolean
     * @throws QueryException
     */
    public function emailExists($email){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XUser');
        return $repository->emailExists($email);
    }


    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllUsers($currentPage = 1, $pageSize = 30){
        /** @var XUserRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Auth\XUser');
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
        $repository = $this->manager->getRepository('AppBundle:Auth\XUserRole');
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
    public function deleteUserRoles($userRoles){
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
        $urRep = $this->manager->getRepository('AppBundle:Auth\XUserRole');
        /** @var XRolePermissionRepository $rpRep */
        $rpRep = $this->manager->getRepository('AppBundle:Auth\XRolePermission');
        /** @var array $map */
        $map=array();

        $useRoles = $urRep->getUserRoles($userId);
        /** @var XUserRole $ur */
        foreach($useRoles as $ur){
            if($ur->getRole()->isEnabled()) {
                $rolePermissions = $rpRep->getRolePermissions($ur->getRole()->getId());
                /** @var XRolePermission $rp */
                foreach ($rolePermissions as $rp) {
                    $map[$rp->getModule() . '.' . $rp->getPermission()] = true;
                }
            }
        }

        return $map;
    }

    /**
     * @param XUser $user
     * @param string $password
     * @return boolean
     */
    public function isPasswordValid(XUser $user,$password){
        /** @var PasswordEncoderInterface $encoder */
        $encoder=$this->encoderFactory->getEncoder($user);
        return $encoder->isPasswordValid(
            $user->getPassword(),
            $password,
            $user->getSalt()
        );

    }
}
