<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/ContentNode.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * this is the base general node content class
 *
 * @ORM\Table(name="content_node")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Content\ContentNodeRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="contentType", type="string")
 * @ORM\DiscriminatorMap({"node" = "ContentNode", "base" = "BaseContent", "article" = "NewsArticle"})
 */
class ContentNode {
    const TYPE_NODE = 'node';
    const TYPE_BASE = 'base';
    const TYPE_ARTICLE = 'article';

    const S_DRAFT = 0;
    const S_PENDING = 1;
    const S_PUBLISHED = 2;

    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $slug
     * @ORM\Column(type="string", length=255)
     */
    protected $slug='';

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var XUser $owner
     * @ORM\ManyToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var DateTime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    protected $modifiedAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(
     *  name="content_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="node_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $categories;

    /**
     * @var int $status
     * @ORM\Column(type="integer")
     */
    protected $status=0;

    /**
     * @var DateTime $publishedAt
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    protected $publishedAt=null;

    public function __construct(){
        $this->categories = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(){
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getModifiedAt(){
        return $this->modifiedAt;
    }

    /**
     * @param DateTime $modifiedAt
     */
    public function setModifiedAt($modifiedAt){
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return string
     */
    public function getType(){
        return self::TYPE_NODE;
    }

    /**
     * @return XUser
     */
    public function getOwner(){
        return $this->owner;
    }

    /**
     * @param XUser $owner
     */
    public function setOwner($owner) {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getSlug(){
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(){
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     */
    public function setCategories($categories){
        $this->categories = $categories;
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

}