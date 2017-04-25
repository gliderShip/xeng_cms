<?php

// src/Xeng/Cms/CoreBundle/Entity/Auth/XRolePermission.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Xeng\Cms\CoreBundle\Repository\Auth\XRolePermissionRepository")
 * @ORM\Table(name="x_role_permission",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="role_permission_unique", columns={"role_id", "permission"})}
 *     )
 *
 */
class XRolePermission {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var XRole
     * @ORM\ManyToOne(targetEntity="XRole")
     */
    private $role;

    /**
     * @var string
     * @ORM\Column(name="permission", type="string", length=512)
     */
    private $permission;

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
     * @return string
     */
    public function getPermission(){
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission($permission){
        $this->permission = $permission;
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

}
