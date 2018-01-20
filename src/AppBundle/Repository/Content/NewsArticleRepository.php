<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Content\NewsArticle;

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
        $qb->from('AppBundle:Content\NewsArticle','na');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return NewsArticle
     * @throws NonUniqueResultException
     */
    public function getNewsArticle($nodeId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('na');
        $qb->from('AppBundle:Content\NewsArticle','na');
        $qb->where('na.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $slug
     * @return NewsArticle
     * @throws NonUniqueResultException
     */
    public function getNewsArticleBySlug($slug){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('na');
        $qb->from('AppBundle:Content\NewsArticle','na');
        $qb->where('na.slug = :slug');
        $qb->andWhere('na.status = 2');
        $qb->setParameter('slug', $slug);

        return $qb->getQuery()->getOneOrNullResult();
    }

}
