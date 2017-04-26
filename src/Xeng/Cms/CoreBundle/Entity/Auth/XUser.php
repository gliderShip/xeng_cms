<?php
// src/Xeng/Cms/CoreBundle/Entity/Auth/XUser.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="x_user")
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Auth\XUserRepository")
 */
class XUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct(){
        parent::__construct();
        $this->xRoles=new ArrayCollection();
    }
}