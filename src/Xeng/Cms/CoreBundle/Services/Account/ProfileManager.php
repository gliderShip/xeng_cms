<?php

// src/Xeng/Cms/CoreBundle/Services/Account/ProfileManager.php

namespace Xeng\Cms\CoreBundle\Services\Account;

use Doctrine\Common\Persistence\ObjectManager;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xeng\Cms\CoreBundle\Entity\Account\Profile;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Repository\Account\ProfileRepository;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ProfileManager {

    /** @var ObjectManager */
    private $manager;

    /** @var Filesystem */
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
     * @param int $profileId
     * @return Profile
     */
    public function getProfile($profileId){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Account\Profile');
        return $repository->getProfile($profileId);
    }

    /**
     * @param int $userId
     * @return Profile
     */
    public function getProfileByUser($userId){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Account\Profile');
        return $repository->getProfileByUser($userId);
    }


    /**
     * @param XUser $user
     * @param string $firstName
     * @param string $lastName
     */
    public function createProfile(XUser $user,$firstName,$lastName){
        /** @var Profile $profile */
        $profile = new Profile();

        $profile->setUser($user);
        $profile->setFirstName($firstName);
        $profile->setLastName($lastName);

        $this->manager->persist($profile);
        $this->manager->flush();
    }

    /**
     * @param integer $profileId
     * @param string $firstName
     * @param string $lastName
     */
    public function updateProfile($profileId,$firstName,$lastName){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('XengCmsCoreBundle:Account\Profile');
        /** @var Profile $profile */
        $profile = $repository->getProfile($profileId);

        $profile->setFirstName($firstName);
        $profile->setLastName($lastName);

        $this->manager->persist($profile);
        $this->manager->flush();
    }

    public function updateProfileImage(Profile $profile, UploadedFile $uploadedFile){

        $storeItem=$storeItemImage->getStoreItem();

        $now=new \DateTime();
        $imageFile = $storeItemImage->getImageFile();
        $imagePath = $storeItem->getId().'_'.$now->getTimestamp().'_'.$imageFile->getClientOriginalName();
        $storeItemImage->setPath($imagePath);

        $this->filesystem->write($imagePath,file_get_contents($imageFile->getRealPath()),true);

        if($storeItem->getDefaultImage()==null){
            $storeItem->setDefaultImage($storeItemImage);
            $this->manager->persist($storeItem);
        }

        $this->manager->persist($storeItemImage);
        $this->manager->flush();
    }

}