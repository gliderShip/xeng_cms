<?php

// src/Xeng/Cms/CoreBundle/Repository/Auth/XRolePermissionRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Auth;

use Doctrine\ORM\EntityRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class RolePermissionRepository extends EntityRepository {

    /**
     * @param int $roleId
     * @param string $appId
     * @return array
     */
    public function getRolePermissions($roleId, $appId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('rp');
        $qb->from('AppBundle:Authorization\RolePermission', 'rp');
        $qb->where('rp.application = :appId');
        $qb->andWhere('rp.role = :roleId');
        $qb->setParameter('appId',$appId);
        $qb->setParameter('roleId',$roleId);

        $query = $qb->getQuery();
        return $query->getResult();
    }

}
