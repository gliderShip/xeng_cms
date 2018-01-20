<?php

namespace AppBundle\Services\Content;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Doctrine\PaginatedResult;
use AppBundle\Doctrine\PaginatorUtil;
use AppBundle\Entity\Content\Category;
use AppBundle\Repository\Content\CategoryRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class CategoryManager {

    /** @var ObjectManager */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param int $categoryId
     * @return Category
     */
    public function getCategory($categoryId){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        return $repository->getCategory($categoryId);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function categoryNameExists($name){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        return $repository->categoryNameExists($name);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllCategories($currentPage = 1, $pageSize = 30){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllCategoriesQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param string $name
     * @param string $label
     * @param $hidden
     */
    public function createCategory($name,$label,$hidden){
        /** @var Category $category */
        $category = new Category();

        $category->setName($name);
        $category->setLabel($label);
        $category->setHidden($hidden);

        $this->manager->persist($category);
        $this->manager->flush();
    }

    /**
     * @param integer $categoryId
     * @param string $name
     * @param string $label
     * @param $hidden
     */
    public function updateCategory($categoryId,$name,$label,$hidden){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategory($categoryId);

        $category->setName($name);
        $category->setLabel($label);
        $category->setHidden($hidden);

        $this->manager->persist($category);
        $this->manager->flush();
    }

}
