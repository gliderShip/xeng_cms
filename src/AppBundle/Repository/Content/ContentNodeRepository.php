<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Content\ContentNode;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentNodeRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getAllNodesQuery()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cn');
        $qb->from('AppBundle:Content\ContentNode', 'cn');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return ContentNode
     * @throws NonUniqueResultException
     */
    public function getNode($nodeId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cn');
        $qb->from('AppBundle:Content\ContentNode', 'cn');
        $qb->where('cn.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
