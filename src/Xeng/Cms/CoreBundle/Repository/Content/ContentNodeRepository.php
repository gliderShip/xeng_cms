<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/ContentNodeRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Content\ContentNode;

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
        $qb->from('XengCmsCoreBundle:Content\ContentNode', 'cn');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return ContentNode
     */
    public function getNode($nodeId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cn');
        $qb->from('XengCmsCoreBundle:Content\ContentNode', 'cn');
        $qb->where('cn.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }
}