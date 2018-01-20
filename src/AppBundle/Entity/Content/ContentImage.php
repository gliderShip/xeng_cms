<?php

namespace AppBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BaseFile;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @ORM\Table(name="content_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Content\ContentImageRepository")
 */
class ContentImage extends BaseFile {

    /**
     * @var BaseContent $content
     * @ORM\ManyToOne(targetEntity="BaseContent")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var string $caption
     * @ORM\Column(type="string", length=255)
     */
    protected $caption='';

    /**
     * @return BaseContent
     */
    public function getOwner(){
        return $this->owner;
    }

    /**
     * @param BaseContent $owner
     */
    public function setOwner($owner){
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getCaption(){
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption($caption){
        $this->caption = $caption;
    }

}
