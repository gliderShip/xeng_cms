<?php
// src/Xeng/Cms/CoreBundle/Entity/Auth/XUser.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\Account\Profile;

/**
 * @ORM\Table(name="x_user")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Auth\XUserRepository")
 */
class XUser extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Profile $profile
     * @ORM\OneToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Account\Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=true)
     */
    private $profile=null;

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return boolean
     */
    public function hasProfile() {
        return $this->profile!==null;
    }

    /**
     * @return string
     */
    public function getFullName() {
        if($this->profile!==null){
            return $this->profile->getFirstName().' '.$this->profile->getLastName();
        } else {
            return $this->username;
        }
    }

    /**
     * @return string
     */
    public function getName() {
        if($this->profile!==null){
            return $this->profile->getFirstName();
        } else {
            return $this->username;
        }
    }

    /**
     * @return Profile
     */
    public function getProfile(){
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile($profile){
        $this->profile = $profile;
    }
}