<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/ContentNode.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use DateTime;
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
 * @ORM\DiscriminatorMap({"node" = "ContentNode", "base" = "BaseContent"})
 */
class ContentNode {
    const TYPE_NODE = 'node';
    const TYPE_BASE = 'base';

    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var XUser $createdBy
     * @ORM\ManyToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @var DateTime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    protected $modifiedAt;


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
     * @return XUser
     */
    public function getCreatedBy(){
        return $this->createdBy;
    }

    /**
     * @param XUser $createdBy
     */
    public function setCreatedBy($createdBy){
        $this->createdBy = $createdBy;
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

}