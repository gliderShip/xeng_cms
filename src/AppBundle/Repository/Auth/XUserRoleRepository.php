<?php

namespace AppBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XUserRoleRepository extends EntityRepository {

    /**
     * @param int $userId
     * @return array
     */
    public function getUserRoles($userId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ur');
        $qb->from('AppBundle:Auth\XUserRole', 'ur');
        $qb->andWhere('ur.user = :userId');
        $qb->setParameter('userId',$userId);

        $query = $qb->getQuery();
        return $query->getResult();
    }

}
