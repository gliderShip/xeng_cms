<?php

// src/Xeng/Cms/CoreBundle/Repository/Content/CategoryRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Xeng\Cms\CoreBundle\Entity\Content\Category;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class CategoryRepository extends EntityRepository {
    /**
     * @return Query
     */
    public function getAllCategoriesQuery(){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('c');
        $qb->from('XengCmsCoreBundle:Content\Category','c');
        return $qb->getQuery();
    }

    /**
     * @param $categoryId
     * @return Category
     */
    public function getCategory($categoryId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('c');
        $qb->from('XengCmsCoreBundle:Content\Category','c');
        $qb->where('c.id = :categoryId');
        $qb->setParameter('categoryId', $categoryId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $name
     * @return Category
     */
    public function getCategoryByName($name){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('c');
        $qb->from('XengCmsCoreBundle:Content\Category','c');
        $qb->where('c.name = :name');
        $qb->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $name
     * @return bool
     */
    public function categoryNameExists($name){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(c)');
        $qb->from('XengCmsCoreBundle:Content\Category','c');
        $qb->where('c.name = :name');
        $qb->setParameter('name', $name);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
}