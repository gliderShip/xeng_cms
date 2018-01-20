<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Content\ContentImage;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentImageRepository extends EntityRepository {

    /**
     * @param $imageId
     * @return ContentImage
     * @throws NonUniqueResultException
     */
    public function getImage($imageId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('ci');
        $qb->from('AppBundle:Content\ContentImage','ci');
        $qb->where('ci.id = :imageId');
        $qb->setParameter('imageId', $imageId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $contentId
     * @return array
     */
    public function getContentImages($contentId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('ci');
        $qb->from('AppBundle:Content\ContentImage','ci');
        $qb->where('ci.owner = :contentId');
        $qb->setParameter('contentId', $contentId);

        return $qb->getQuery()->getResult();
    }
}
