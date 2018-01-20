<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentCategoryRepository extends EntityRepository {
    /**
     * @param int $nodeId
     * @return array
     */
    public function getContentCategories($nodeId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cc');
        $qb->from('AppBundle:Content\ContentCategory', 'cc');
        $qb->andWhere('cc.node = :nodeId');
        $qb->setParameter('nodeId',$nodeId);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public function getCategoryContentIds($categoryId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('IDENTITY(cc.node)');
        $qb->from('AppBundle:Content\ContentCategory', 'cc');
        $qb->andWhere('cc.category = :categoryId');
        $qb->setParameter('categoryId',$categoryId);

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

}
