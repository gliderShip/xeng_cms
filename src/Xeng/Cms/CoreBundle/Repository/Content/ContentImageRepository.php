<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/ContentImageRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Content\ContentImage;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentImageRepository extends EntityRepository {

    /**
     * @param $imageId
     * @return ContentImage
     */
    public function getImage($imageId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('ci');
        $qb->from('XengCmsCoreBundle:Content\ContentImage','ci');
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
        $qb->from('XengCmsCoreBundle:Content\ContentImage','ci');
        $qb->where('ci.owner = :contentId');
        $qb->setParameter('contentId', $contentId);

        return $qb->getQuery()->getResult();
    }
}