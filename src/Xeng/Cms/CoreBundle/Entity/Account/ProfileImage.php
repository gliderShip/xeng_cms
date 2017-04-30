<?php

// src/Xeng/Cms/CoreBundle/Entity/Account/ProfileImage.php

namespace Xeng\Cms\CoreBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\BaseImage;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @ORM\Table(name="x_profile_image")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Account\ProfileImageRepository")
 */
class ProfileImage extends BaseImage {

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
