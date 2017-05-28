<?php
// src/Xeng/Cms/CoreBundle/Entity/Content/Category.php

namespace Xeng\Cms\CoreBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Content\CategoryRepository")
 */
class Category {
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=150)
     */
    private $label;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $hidden=false;

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
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(){
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label){
        $this->label = $label;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

}