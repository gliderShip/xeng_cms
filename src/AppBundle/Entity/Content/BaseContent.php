<?php

namespace AppBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Auth\XUser;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * this is the base web content class, that has common basic fields needed for all types of web content
 *
 * @ORM\Table(name="base_content")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Content\BaseContentRepository")
 */
class BaseContent extends ContentNode {

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
     * @var XUser $author
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    protected $author;

    /**
     * @return boolean
     */
    public function hasImage() {
        return $this->image!==null;
    }

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
     * @return string
     */
    public function getType(){
        return self::TYPE_BASE;
    }



}
