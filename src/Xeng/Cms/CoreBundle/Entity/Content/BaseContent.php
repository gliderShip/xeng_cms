<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/BaseContent.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * this is the base web content class, that has common basic fields needed for all types of web content
 *
 * @ORM\Table(name="base_content")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Content\BaseContentRepository")
 */
class BaseContent extends ContentNode {
    const S_DRAFT = 0;
    const S_PENDING = 1;
    const S_PUBLISHED = 2;

    /**
     * @var string $title
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    protected $title;

    /**
     * @var ContentImage $image
     * @ORM\OneToOne(targetEntity="ContentImage")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    protected $image=null;

    /**
     * @var int $status
     * @ORM\Column(type="integer")
     */
    protected $status=0;

    /**
     * @var XUser $author
     * @ORM\ManyToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var DateTime $publishedAt
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    protected $publishedAt;

    /**
     * @return string
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title){
        $this->title = $title;
    }

    /**
     * @return ContentImage
     */
    public function getImage(){
        return $this->image;
    }

    /**
     * @param ContentImage $image
     */
    public function setImage($image){
        $this->image = $image;
    }

    /**
     * @return XUser
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * @param XUser $author
     */
    public function setAuthor($author){
        $this->author = $author;
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt(){
        return $this->publishedAt;
    }

    /**
     * @param DateTime $publishedAt
     */
    public function setPublishedAt($publishedAt){
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return string
     */
    public function getType(){
        return self::TYPE_BASE;
    }

    /**
     * @return int
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status){
        $this->status = $status;
    }

}