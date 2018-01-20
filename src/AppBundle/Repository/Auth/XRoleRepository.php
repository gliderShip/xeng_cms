<?php

namespace AppBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Auth\XRole;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XRoleRepository extends EntityRepository {
    /**
     * @return Query
     */
    public function getAllRolesQuery(){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('r');
        $qb->from('AppBundle:Auth\XRole','r');
        return $qb->getQuery();
    }

    /**
     * @param $roleId
     * @return XRole
     * @throws NonUniqueResultException
     */
    public function getRole($roleId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('r');
        $qb->from('AppBundle:Auth\XRole','r');
        $qb->where('r.id = :roleId');
        $qb->setParameter('roleId', $roleId);

        return $qb->getQuery()->getOneOrNullResult();
    }


    /**
     * @param $name
     * @return bool
     * @throws Query\QueryException
     */
    public function roleNameExists($name){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(r)');
        $qb->from('AppBundle:Auth\XRole','r');
        $qb->where('r.name = :name');
        $qb->setParameter('name', $name);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
}
