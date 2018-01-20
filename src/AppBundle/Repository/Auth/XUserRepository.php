<?php

namespace AppBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Auth\XUser;
use Doctrine\ORM\Query\QueryException;

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
        $qb->from('AppBundle:Auth\XUser','u');
        return $qb->getQuery();
    }

    /**
     * @param $userId
     * @return XUser
     * @throws NonUniqueResultException
     */
    public function getUser($userId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('u');
        $qb->from('AppBundle:Auth\XUser','u');
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
     * @throws QueryException
     */
    public function usernameExists($username){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(u)');
        $qb->from('AppBundle:Auth\XUser','u');
        $qb->where('u.username = :username');
        $qb->setParameter('username', $username);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }

    /**
     * @param $email
     * @return bool
     * @throws QueryException
     */
    public function emailExists($email){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(u)');
        $qb->from('AppBundle:Auth\XUser','u');
        $qb->where('u.email = :email');
        $qb->setParameter('email', $email);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
}
