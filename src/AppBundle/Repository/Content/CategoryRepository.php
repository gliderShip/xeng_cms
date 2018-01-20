<?php

namespace AppBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use AppBundle\Entity\Content\Category;
use Doctrine\ORM\Query\QueryException;

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
        $qb->from('AppBundle:Content\Category','c');
        return $qb->getQuery();
    }

    /**
     * @param $categoryId
     * @return Category
     * @throws NonUniqueResultException
     */
    public function getCategory($categoryId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('c');
        $qb->from('AppBundle:Content\Category','c');
        $qb->where('c.id = :categoryId');
        $qb->setParameter('categoryId', $categoryId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $name
     * @return Category
     * @throws NonUniqueResultException
     */
    public function getCategoryByName($name){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('c');
        $qb->from('AppBundle:Content\Category','c');
        $qb->where('c.name = :name');
        $qb->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $name
     * @return bool
     * @throws QueryException
     */
    public function categoryNameExists($name){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('count(c)');
        $qb->from('AppBundle:Content\Category','c');
        $qb->where('c.name = :name');
        $qb->setParameter('name', $name);
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
}
