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

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="XRole")
     * @ORM\JoinTable(name="x_user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     */
    private $xRoles;

    public function __construct(){
        parent::__construct();
        $this->xRoles=new ArrayCollection();
    }

    /**
     * Add role
     *
     * @param XRole $role
     *
     * @return XUser
     */
    public function addXRole(XRole $xRole){
        $this->xRoles->add($xRole);
        return $this;
    }

    /**
     * Get x roles
     *
     * @return ArrayCollection
     */
    public function getXRoles(){
        return $this->xRoles;
    }

    /**
     * @param ArrayCollection $xRoles
     */
    public function setXRoles($xRoles)
    {
        $this->xRoles = $xRoles;
    }
}