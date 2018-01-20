<?php

namespace AppBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class XRolePermissionRepository extends EntityRepository {

    /**
     * @param int $roleId
     * @return array
     */
    public function getRolePermissions($roleId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('rp');
        $qb->from('AppBundle:Auth\XRolePermission', 'rp');
        $qb->andWhere('rp.role = :roleId');
        $qb->setParameter('roleId',$roleId);

        $query = $qb->getQuery();
        return $query->getResult();
    }

}
