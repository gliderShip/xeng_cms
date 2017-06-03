<?php

// src/Xeng/Cms/CoreBundle/Services/Content/ContentManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Content\Category;
use Xeng\Cms\CoreBundle\Entity\Content\ContentCategory;
use Xeng\Cms\CoreBundle\Entity\Content\ContentNode;
use Xeng\Cms\CoreBundle\Repository\Content\BaseContentRepository;
use Xeng\Cms\CoreBundle\Repository\Content\CategoryRepository;
use Xeng\Cms\CoreBundle\Repository\Content\ContentCategoryRepository;
use Xeng\Cms\CoreBundle\Repository\Content\ContentNodeRepository;

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
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentNode');
        return $repository->getNode($nodeId);
    }

    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllNodes($currentPage = 1, $pageSize = 30){
        /** @var ContentNodeRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentNode');
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
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentCategory');
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
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentCategory');

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
     * @throws NotFoundHttpException
     */
    public function findContentByCategory($categoryName, $limit){

        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategoryByName($categoryName);

        if(!$category){
            throw new NotFoundHttpException();
        }

        //get all content node ids that have this category
        /** @var ContentCategoryRepository $contentCategoryRepository */
        $contentCategoryRepository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentCategory');

        $contentIds = $contentCategoryRepository->getCategoryContentIds($category->getId());
        $ids=array();
        foreach ($contentIds as $contentId){
            $ids[]=$contentId[1];
        }

        /** @var BaseContentRepository $baseContentRepository */
        $baseContentRepository = $this->manager->getRepository('XengCmsCoreBundle:Content\BaseContent');

        $contents=$baseContentRepository->getBaseContentByIds($ids,$limit);
        return $contents;

    }

    /**
     * @param string $categoryName
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     * @throws NotFoundHttpException
     */
    public function findContentByCategoryPaginated($categoryName,$currentPage = 1, $pageSize = 30){

        /** @var CategoryRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\Category');
        /** @var Category $category */
        $category = $repository->getCategoryByName($categoryName);

        if(!$category){
            throw new NotFoundHttpException();
        }

        //get all content node ids that have this category
        /** @var ContentCategoryRepository $contentCategoryRepository */
        $contentCategoryRepository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentCategory');

        $contentIds = $contentCategoryRepository->getCategoryContentIds($category->getId());
        $ids=array();
        foreach ($contentIds as $contentId){
            $ids[]=$contentId[1];
        }

        /** @var BaseContentRepository $baseContentRepository */
        $baseContentRepository = $this->manager->getRepository('XengCmsCoreBundle:Content\BaseContent');

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
        $baseContentRepository = $this->manager->getRepository('XengCmsCoreBundle:Content\BaseContent');

        return $baseContentRepository->getBaseContentListLatest($limit);

    }


}