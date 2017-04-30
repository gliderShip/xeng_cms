<?php
// src/Xeng/Cms/CoreBundle/Entity/Account/Profile.php

namespace Xeng\Cms\CoreBundle\Entity\Account;

use Doctrine\ORM\Mapping as ORM;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;

/**
 * @ORM\Table(name="x_profile")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Account\ProfileRepository")
 */
class Profile {
    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id=-1;

    /**
     * @var XUser $user
     * @ORM\OneToOne(targetEntity="Xeng\Cms\CoreBundle\Entity\Auth\XUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string $firstName
     * @ORM\Column(type="string", length=150)
     */
    private $firstName='';

    /**
     * @var string $lastName
     * @ORM\Column(type="string", length=150)
     */
    private $lastName='';

    /**
     * @var ProfileImage $image
     * @ORM\OneToOne(targetEntity="ProfileImage")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    private $image=null;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return XUser
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param XUser $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return ProfileImage
     */
    public function getImage(){
        return $this->image;
    }

    /**
     * @param ProfileImage $image
     */
    public function setImage($image){
        $this->image = $image;
    }

}