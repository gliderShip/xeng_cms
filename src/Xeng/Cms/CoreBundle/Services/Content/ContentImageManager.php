<?php

// src/Xeng/Cms/CoreBundle/Services/Content/ContentImageManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use Doctrine\Common\Persistence\ObjectManager;
use Gaufrette\Filesystem;
use Xeng\Cms\CoreBundle\Entity\Content\ContentImage;
use Xeng\Cms\CoreBundle\Repository\Content\ContentImageRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ContentImageManager {

    /** @var ObjectManager $manager */
    private $manager;

    /** @var Filesystem $filesystem*/
    private $filesystem;

    /**
     * @param ObjectManager $manager
     * @param Filesystem $filesystem
     */
    public function __construct(ObjectManager $manager, Filesystem $filesystem) {
        $this->manager = $manager;
        $this->filesystem = $filesystem;
    }

    /**
     * @param int $imageId
     * @return ContentImage
     */
    public function getImage($imageId){
        /** @var ContentImageRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentImage');
        return $repository->getImage($imageId);
    }

    /**
     * @param int $contentId
     * @return array
     */
    public function getContentImages($contentId){
        /** @var ContentImageRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Content\ContentImage');
        return $repository->getContentImages($contentId);
    }

}