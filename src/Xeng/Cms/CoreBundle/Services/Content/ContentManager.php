<?php

// src/Xeng/Cms/CoreBundle/Services/Content/ContentManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use utilphp\util;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Entity\Content\Category;
use Xeng\Cms\CoreBundle\Entity\Content\ContentCategory;
use Xeng\Cms\CoreBundle\Entity\Content\ContentImage;
use Xeng\Cms\CoreBundle\Entity\Content\ContentNode;
use Xeng\Cms\CoreBundle\Entity\Content\NewsArticle;
use Xeng\Cms\CoreBundle\Repository\Content\ContentCategoryRepository;
use Xeng\Cms\CoreBundle\Repository\Content\ContentNodeRepository;
use Xeng\Cms\CoreBundle\Repository\Content\NewsArticleRepository;

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
}