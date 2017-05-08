<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/NewsArticleRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Content\NewsArticle;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class NewsArticleRepository extends EntityRepository {
    /**
     * @return Query
     */
    public function getAllNewsArticlesQuery(){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('na');
        $qb->from('XengCmsCoreBundle:Content\NewsArticle','na');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return NewsArticle
     */
    public function getNewsArticle($nodeId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('na');
        $qb->from('XengCmsCoreBundle:Content\NewsArticle','na');
        $qb->where('na.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }

}