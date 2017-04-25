<?php

// src/Xeng/Cms/CoreBundle/Repository/Auth/XUserRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XUserRepository extends EntityRepository {
    /**
     * @return Query
     */
    public function getAllUsersQuery(){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('u');
        $qb->from('XengCmsCoreBundle:Auth\XUser','u');
        return $qb->getQuery();
    }

    /**
     * @param $userId
     * @return XUser
     */
    public function getUser($userId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('u');
        $qb->from('XengCmsCoreBundle:Auth\XUser','u');
        $qb->where('u.id = :userId');
        $qb->setParameter('userId', $userId);
        /** @var XUser $user */
        $user=$qb->getQuery()->getOneOrNullResult();
        if($user){
            $user->setPassword(null);
        }
        return $user;
    }

    /**
     * @param $username
     * @return bool
     */
    public function usernameExists($username){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(u)');
        $qb->from('XengCmsCoreBundle:Auth\XUser','u');
        $qb->where('u.username = :username');
        $qb->setParameter('username', $username);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailExists($email){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(u)');
        $qb->from('XengCmsCoreBundle:Auth\XUser','u');
        $qb->where('u.email = :email');
        $qb->setParameter('email', $email);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
}