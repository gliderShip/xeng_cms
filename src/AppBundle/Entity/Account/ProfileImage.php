<?php

namespace AppBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BaseFile;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @ORM\Table(name="x_profile_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Account\ProfileImageRepository")
 */
class ProfileImage extends BaseFile {

    /**
     * @var Profile $profile
     * @ORM\OneToOne(targetEntity="Profile")
     * @ORM\JoinColumn(name="profile", referencedColumnName="id")
     */
    protected $profile;

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

}
