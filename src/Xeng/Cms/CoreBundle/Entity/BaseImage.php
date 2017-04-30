<?php

// src/Xeng/Cms/CoreBundle/Entity/BaseImage.php

namespace Xeng\Cms\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the base class for all image assets
 */
class BaseImage {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $path;

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


}
