<?php

// src/Xeng/Cms/CoreBundle/Services/Account/ProfileManager.php

namespace Xeng\Cms\CoreBundle\Services\Account;

use Doctrine\Common\Persistence\ObjectManager;
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

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
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

}