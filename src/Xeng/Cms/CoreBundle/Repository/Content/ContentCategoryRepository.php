<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/ContentCategoryRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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
        $qb->from('XengCmsCoreBundle:Content\ContentCategory', 'cc');
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
        $qb->from('XengCmsCoreBundle:Content\ContentCategory', 'cc');
        $qb->andWhere('cc.category = :categoryId');
        $qb->setParameter('categoryId',$categoryId);

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

}