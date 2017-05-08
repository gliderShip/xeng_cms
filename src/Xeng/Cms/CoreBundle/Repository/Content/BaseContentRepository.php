<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/BaseContentRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Content\BaseContent;

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
        $qb->from('XengCmsCoreBundle:Content\BaseContent','bc');
        return $qb->getQuery();
    }

    /**
     * @param $nodeId
     * @return BaseContent
     */
    public function getBaseContent($nodeId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('bc');
        $qb->from('XengCmsCoreBundle:Content\BaseContent','bc');
        $qb->where('bc.id = :nodeId');
        $qb->setParameter('nodeId', $nodeId);

        return $qb->getQuery()->getOneOrNullResult();
    }

}