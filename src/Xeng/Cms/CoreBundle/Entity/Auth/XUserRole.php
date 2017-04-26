<?php

// src/Xeng/Cms/CoreBundle/Entity/Auth/XUserRole.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Auth\XUserRoleRepository")
 * @ORM\Table(name="x_user_role",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="user_role_unique", columns={"user_id", "role_id"})}
 *     )
 *
 */
class XUserRole {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var XUser $user
     * @ORM\ManyToOne(targetEntity="XUser")
     */
    private $user;

    /**
     * @var XRole $role
     * @ORM\ManyToOne(targetEntity="XRole")
     */
    private $role;

    /**
     * @return XRole
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * @param XRole $role
     */
    public function setRole($role){
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * @return XUser
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param XUser $user
     */
    public function setUser($user){
        $this->user = $user;
    }

}
