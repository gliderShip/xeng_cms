<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/NewsArticle.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * this is the base web content class, that has common basic fields needed for all types of web content
 *
 * @ORM\Table(name="news_article")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Content\NewsArticleRepository")
 */
class NewsArticle extends BaseContent {

    /**
     * @var string $summary
     * @ORM\Column(type="string", length=255)
     */
    protected $summary='';

    /**
     * @var string $body
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @return string
     */
    public function getBody(){
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body){
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary){
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getType(){
        return self::TYPE_ARTICLE;
    }

}