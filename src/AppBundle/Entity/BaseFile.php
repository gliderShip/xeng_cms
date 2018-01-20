<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the base class for all file assets, including images
 */
class BaseFile {

    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $path
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $path;

    /**
     * @var string $originalName
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $originalName;

    /**
     * @var string $mimeType
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $mimeType;

    /**
     * @var int $size
     *
     * @ORM\Column(name="size", type="integer")
     */
    protected $size;

    /**
     * @var DateTime $lastUpdated
     * @ORM\Column(type="datetime")
     */
    protected $lastUpdated;

    public function __construct(){
        $this->lastUpdated=new DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(){
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path){
        $this->path = $path;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdated(){
        return $this->lastUpdated;
    }

    /**
     * @param DateTime $lastUpdated
     */
    public function setLastUpdated($lastUpdated){
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @return string
     */
    public function getOriginalName(){
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName($originalName){
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getMimeType(){
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType){
        $this->mimeType = $mimeType;
    }

    /**
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }


}
