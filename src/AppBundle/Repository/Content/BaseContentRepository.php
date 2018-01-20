<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Content\BaseContent;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class BaseContentRepository extends EntityRepository {
    /**
     * @return Query
     */
    public function getAllBaseContentQuery(){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc');
        $qb->from('AppBundle:Content\BaseContent','bc');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return BaseContent
     * @throws NonUniqueResultException
     */
    public function getBaseContent($nodeId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc');
        $qb->from('AppBundle:Content\BaseContent','bc');
        $qb->where('bc.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param array $nodeIds
     * @param int $limit
     * @return array
     */
    public function getBaseContentByIds($nodeIds, $limit){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc,ci');
        $qb->from('AppBundle:Content\BaseContent','bc');
        $qb->innerJoin('bc.image', 'ci');
        $qb->where('bc.status = 2');
        $qb->andWhere($qb->expr()->in('bc.id', '?1'));
        $qb->orderBy('bc.publishedAt', 'DESC');
        $qb->setParameter('1', $nodeIds);
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param array $nodeIds
     * @return Query
     */
    public function getBaseContentByIdsQuery($nodeIds){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc,ci,cat');
        $qb->from('AppBundle:Content\BaseContent','bc');
        $qb->innerJoin('bc.image', 'ci');
        $qb->innerJoin('bc.contentCategories', 'cat');
        $qb->where('bc.status = 2');
        $qb->andWhere($qb->expr()->in('bc.id', '?1'));
        $qb->orderBy('bc.publishedAt', 'DESC');
        $qb->setParameter('1', $nodeIds);

        return $qb->getQuery();
    }

    /**
     * @param $limit
     * @return array
     */
    public function getBaseContentListLatest($limit){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc');
        $qb->from('AppBundle:Content\BaseContent','bc');
        $qb->where('bc.status = 2');
        $qb->orderBy('bc.publishedAt', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }

}
