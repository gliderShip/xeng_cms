<?php

// src/Xeng/Cms/CoreBundle/Services/Content/ContentImageManager.php

namespace Xeng\Cms\CoreBundle\Services\Content;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xeng\Cms\CoreBundle\Entity\Content\BaseContent;
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

    /**
     * @param BaseContent $content
     * @param UploadedFile $uploadedFile
     * @return ContentImage
     */
    public function addContentImage(BaseContent $content, UploadedFile $uploadedFile){
        $now=new DateTime();

        $image=new ContentImage();
        $image->setOwner($content);

        $originalName=$uploadedFile->getClientOriginalName();
        if(!$originalName){
            $originalName=''.$now->getTimestamp();
        }

        $imageExtension = $uploadedFile->getClientOriginalExtension();
        $imagePath = $now->getTimestamp().'_'.md5($uploadedFile->getClientOriginalName()).'.'.$imageExtension;

        $image->setPath($imagePath);
        $image->setOriginalName($originalName);
        $image->setMimeType($uploadedFile->getMimeType());
        $image->setSize($uploadedFile->getSize());

        $this->filesystem->write($imagePath,file_get_contents($uploadedFile->getRealPath()),true);

        $this->manager->persist($image);
        $this->manager->flush();

        return $image;
    }

    /**
     * @param ContentImage $image
     */
    public function deleteImage($image){
        $this->filesystem->delete($image->getPath());
        $this->manager->remove($image);
        $this->manager->flush();
    }


}