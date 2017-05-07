<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/BaseContent.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
    const S_REDACTING = 2;
    const S_PUBLISHED = 3;


    /**
     * @var string $title
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    protected $title;

    /**
     * @var string $description
     * @ORM\Column(type="string", length=150)
     */
    protected $description;

    /**
     * @var ContentImage $image
     * @ORM\OneToOne(targetEntity="ContentImage")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    protected $image=null;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ContentImage", mappedBy="owner")
     */
    protected $images;

    /**
     * @var XUser $author
     * @ORM\ManyToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var DateTime $publishedAt
     *
     * @ORM\Column(name="modified_at", type="datetime")
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
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description){
        $this->description = $description;
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
     * @return ArrayCollection
     */
    public function getImages(){
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     */
    public function setImages($images){
        $this->images = $images;
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

}