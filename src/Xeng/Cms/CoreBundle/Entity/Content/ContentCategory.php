<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/ContentCategory.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @ORM\Table(name="content_category")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Content\ContentCategoryRepository")
 */
class ContentCategory {
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ContentNode $node
     * @ORM\ManyToOne(targetEntity="ContentNode")
     */
    private $node;

    /**
     * @var Category $category
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

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
     * @return ContentNode
     */
    public function getNode(){
        return $this->node;
    }

    /**
     * @param ContentNode $node
     */
    public function setNode($node){
        $this->node = $node;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category){
        $this->category = $category;
    }

}