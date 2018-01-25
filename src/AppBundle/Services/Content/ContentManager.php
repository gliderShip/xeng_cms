<?php

namespace AppBundle\Services\Content;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Exception\CategoryNotFoundException;
use AppBundle\Doctrine\PaginatedResult;
use AppBundle\Doctrine\PaginatorUtil;
use AppBundle\Entity\Content\Category;
use AppBundle\Entity\Content\ContentCategory;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Repository\Content\BaseContentRepository;
use AppBundle\Repository\Content\CategoryRepository;
use AppBundle\Repository\Content\ContentCategoryRepository;
use AppBundle\Repository\Content\ContentNodeRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentManager {

    /** @var ObjectManager $manager */
    private $manager;

    /** @var ContentImageManager $imageManager */
    private $imageManager;

    /**
     * @param ObjectManager $manager
     * @param ContentImageManager $imageManager
     */
    public function __construct(ObjectManager $manager, ContentImageManager $imageManager) {
        $this->manager = $manager;
        $this->imageManager = $imageManager;
    }

    /**
     * @param int $nodeId
     * @return ContentNode
     */
    public function getContentNode($nodeId){
        /** @var ContentNodeRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\ContentNode');
        return $repository->getNode($nodeId);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllNodes($currentPage = 1, $pageSize = 30){
        /** @var ContentNodeRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\ContentNode');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllNodesQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param integer $nodeId
     * @return array content category map
     */
    public function getContentCategoryMap($nodeId){
        /** @var ContentCategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\ContentCategory');
        /** @var array $map */
        $map=array();

        $contentCategories = $repository->getContentCategories($nodeId);
        /** @var ContentCategory $cc */
        foreach($contentCategories as $cc){
            $map['category_'.$cc->getCategory()->getId()]=$cc;
        }

        return $map;
    }

    /**
     * @param integer $nodeId
     * @return array
     */
    public function getContentCategories($nodeId){
        /** @var ContentCategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\ContentCategory');

        $contentCategories = $repository->getContentCategories($nodeId);

        return $contentCategories;
    }

    /**
     * @param array $contentCategories
     */
    public function deleteContentCategories($contentCategories){
        /** @var ContentCategory $cc */

        foreach($contentCategories as $cc){
            $this->manager->remove($cc);
        }

        $this->manager->flush();
    }

    /**
     * @param ContentNode $content
     * @param array $categories
     */
    public function addContentCategories(ContentNode $content,$categories){
        /** @var Category $category */
        foreach($categories as $category){

            /** @var ContentCategory $cc */
            $cc=new ContentCategory();
            $cc->setNode($content);
            $cc->setCategory($category);
            $this->manager->persist($cc);
        }

        $this->manager->flush();
    }

    /**
     * @param string $categoryName
     * @param int $limit
     * @return array
     * @throws CategoryNotFoundException
     */
    public function findContentByCategory($categoryName, $limit){

        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategoryByName($categoryName);

        if(!$category){
            throw new CategoryNotFoundException($categoryName);
        }

        //get all content node ids that have this category
        /** @var ContentCategoryRepository $contentCategoryRepository */
        $contentCategoryRepository = $this->manager->getRepository('AppBundle:Content\ContentCategory');

        $contentIds = $contentCategoryRepository->getCategoryContentIds($category->getId());
        $ids=array();
        foreach ($contentIds as $contentId){
            $ids[]=$contentId[1];
        }

        /** @var BaseContentRepository $baseContentRepository */
        $baseContentRepository = $this->manager->getRepository('AppBundle:Content\BaseContent');

        $contents=$baseContentRepository->getBaseContentByIds($ids,$limit);
        return $contents;

    }

    /**
     * @param string $categoryName
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     * @throws CategoryNotFoundException
     */
    public function findContentByCategoryPaginated($categoryName,$currentPage = 1, $pageSize = 30){

        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategoryByName($categoryName);

        if(!$category){
            throw new CategoryNotFoundException($categoryName);
        }

        //get all content node ids that have this category
        /** @var ContentCategoryRepository $contentCategoryRepository */
        $contentCategoryRepository = $this->manager->getRepository('AppBundle:Content\ContentCategory');

        $contentIds = $contentCategoryRepository->getCategoryContentIds($category->getId());
        $ids=array();
        foreach ($contentIds as $contentId){
            $ids[]=$contentId[1];
        }

        /** @var BaseContentRepository $baseContentRepository */
        $baseContentRepository = $this->manager->getRepository('AppBundle:Content\BaseContent');

       /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($baseContentRepository->getBaseContentByIdsQuery($ids),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();

    }

    /**
     * @param int $limit
     * @return array
     */
    public function getLatestBaseContentList($limit=7){

        /** @var BaseContentRepository $baseContentRepository */
        $baseContentRepository = $this->manager->getRepository('AppBundle:Content\BaseContent');

        return $baseContentRepository->getBaseContentListLatest($limit);

    }


}
