<?php

namespace AppBundle\Services\Account;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Gaufrette\Filesystem;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Account\Profile;
use AppBundle\Entity\Account\ProfileImage;
use AppBundle\Entity\Auth\XUser;
use AppBundle\Repository\Account\ProfileRepository;
use AppBundle\Util\MemoryLogger;

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
     * @throws NonUniqueResultException
     */
    public function getProfile($profileId){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Account\Profile');
        return $repository->getProfile($profileId);
    }

    /**
     * @param int $userId
     * @return Profile
     * @throws NonUniqueResultException
     */
    public function getProfileByUser($userId){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Account\Profile');
        return $repository->getProfileByUser($userId);
    }


    /**
     * @param XUser $user
     * @param string $firstName
     * @param string $lastName
     * @return Profile
     */
    public function createProfile(XUser $user,$firstName,$lastName){
        /** @var Profile $profile */
        $profile = new Profile();

        $profile->setUser($user);
        $profile->setFirstName($firstName);
        $profile->setLastName($lastName);

        $user->setProfile($profile);

        $this->manager->persist($profile);
        $this->manager->persist($user);
        $this->manager->flush();
        return $profile;
    }

    /**
     * @param integer $profileId
     * @param string $firstName
     * @param string $lastName
     * @return Profile
     * @throws NonUniqueResultException
     */
    public function updateProfile($profileId,$firstName,$lastName){
        /** @var ProfileRepository $repository */
        $repository = $this->manager->getRepository('AppBundle:Account\Profile');
        /** @var Profile $profile */
        $profile = $repository->getProfile($profileId);

        $profile->setFirstName($firstName);
        $profile->setLastName($lastName);

        $this->manager->persist($profile);
        $this->manager->flush();
        return $profile;
    }

    /**
     * @param Profile $profile
     * @param UploadedFile $uploadedFile
     */
    public function updateProfileImage(Profile $profile, UploadedFile $uploadedFile){
        $profileImage=$profile->getImage();
        $now=new DateTime();

        //image already exists, update the file and info only
        if($profileImage){
            $profileImage->setLastUpdated($now);
            try{
                $this->filesystem->delete($profileImage->getPath());
            } catch(Exception $exception){
                MemoryLogger::log($exception);
            }
        } else {
            $profileImage=new ProfileImage();
            $profileImage->setProfile($profile);
            $profile->setImage($profileImage);
        }

        $originalName=$uploadedFile->getClientOriginalName();
        if(!$originalName){
            $originalName=''.$now->getTimestamp();
        }

        $imageExtension = $uploadedFile->getClientOriginalExtension();
        $imagePath = $now->getTimestamp().'_'.md5($uploadedFile->getClientOriginalName()).'.'.$imageExtension;

        $profileImage->setPath($imagePath);
        $profileImage->setOriginalName($originalName);
        $profileImage->setMimeType($uploadedFile->getMimeType());
        $profileImage->setSize($uploadedFile->getSize());

        $this->filesystem->write($imagePath,file_get_contents($uploadedFile->getRealPath()),true);

        $this->manager->persist($profileImage);
        $this->manager->flush();
    }

}
