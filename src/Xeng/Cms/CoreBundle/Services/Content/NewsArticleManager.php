<?php

// src/Xeng/Cms/CoreBundle/Services/Content/NewsArticleManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use utilphp\util;
use Xeng\Cms\CoreBundle\Doctrine\PaginatedResult;
use Xeng\Cms\CoreBundle\Doctrine\PaginatorUtil;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Entity\Content\ContentImage;
use Xeng\Cms\CoreBundle\Entity\Content\NewsArticle;
use Xeng\Cms\CoreBundle\Repository\Content\NewsArticleRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class NewsArticleManager {

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
     * @return NewsArticle
     */
    public function getNewsArticle($nodeId){
        /** @var NewsArticleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\NewsArticle');
        return $repository->getNewsArticle($nodeId);
    }

    /**
     * @param string $slug
     * @return NewsArticle
     */
    public function getNewsArticleBySlug($slug){
        /** @var NewsArticleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\NewsArticle');
        return $repository->getNewsArticleBySlug($slug);
    }


    /**
     * @param int $currentPage
     * @param int $pageSize
     * @return PaginatedResult
     */
    public function getAllNewsArticle($currentPage = 1, $pageSize = 30){
        /** @var NewsArticleRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\NewsArticle');
        /** @var PaginatorUtil $paginator */
        $paginator = new PaginatorUtil($repository->getAllNewsArticlesQuery(),$currentPage,$pageSize);
        return $paginator->getPaginatedResult();
    }

    /**
     * @param XUser $owner
     * @param string $title
     * @param string $summary
     * @param string $body
     * @return NewsArticle
     */
    public function createArticle(XUser $owner,$title,$summary,$body){
        /** @var NewsArticle $article */
        $article = new NewsArticle();

        $now=new DateTime('now');

        $article->setCreatedAt($now);
        $article->setModifiedAt($now);
        $article->setOwner($owner);
        $article->setTitle($title);
        $article->setSlug(trim(util::slugify($title),'-'));

        if($summary!==null){
            $article->setSummary($summary);
        } else {
            $article->setSummary('');
        }

        if($body!==null){
            $article->setBody($body);
        } else {
            $article->setBody('');
        }

        $this->manager->persist($article);
        $this->manager->flush();

        return $article;
    }

    /**
     * @param NewsArticle $article
     * @param string $title
     * @param string $summary
     * @param string $body
     * @param int $status
     * @return NewsArticle
     */
    public function updateArticle(NewsArticle $article,$title,$summary,$body,$status){
        $now=new DateTime('now');

        $article->setModifiedAt($now);
        $article->setTitle($title);
        $article->setSlug(trim(util::slugify($title),'-'));

        $article->setStatus($status);
        if($status==2 && $article->getStatus()!=2){
            $article->setPublishedAt($now);
        }

        if($summary!==null){
            $article->setSummary($summary);
        } else {
            $article->setSummary('');
        }

        if($body!==null){
            $article->setBody($body);
        } else {
            $article->setBody('');
        }

        $this->manager->persist($article);
        $this->manager->flush();

        return $article;
    }

    /**
     * @param NewsArticle $article
     * @param ContentImage $image
     * @param bool $flush
     */
    public function setArticleImage(NewsArticle $article,$image,$flush=false){
        $now=new DateTime('now');
        $article->setModifiedAt($now);

        $article->setImage($image);

        $this->manager->persist($article);
        if($flush){
            $this->manager->flush();
        }
    }

}