<?php

// src/Xeng/Cms/CoreBundle/Services/Content/CategoryManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use Doctrine\Common\Persistence\ObjectManager;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Content\Category;
use Xeng\Cms\CoreBundle\Repository\Content\CategoryRepository;

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
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        return $repository->getCategory($categoryId);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function categoryNameExists($name){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        return $repository->categoryNameExists($name);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllCategories($currentPage = 1, $pageSize = 30){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllCategoriesQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param string $name
     * @param string $label
    */
    public function createCategory($name,$label){
        /** @var Category $category */
        $category = new Category();

        $category->setName($name);
        $category->setLabel($label);

        $this->manager->persist($category);
        $this->manager->flush();
    }

    /**
     * @param integer $categoryId
     * @param string $name
     * @param string $label
     */
    public function updateCategory($categoryId,$name,$label){
        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategory($categoryId);

        $category->setName($name);
        $category->setLabel($label);

        $this->manager->persist($category);
        $this->manager->flush();
    }

}