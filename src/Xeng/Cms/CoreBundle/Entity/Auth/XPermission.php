<?php

// src/Xeng/Cms/CoreBundle/Entity/Auth/XPermission.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;

class XPermission {
    /**
     * @var string
     */
    private $id;

    /**
     * @var boolean
     */
    private $abstract=false;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $children;

    /**
     * @var boolean
     */
    private $enabled=false;
    /**
     * @var int
     */
    private $rolePermissionId=-1;

    /**
     * Constructor
     * @param array $values
     */
    public function __construct($values = array())
    {
        $this->children = new ArrayCollection();
        foreach($values as $k => $v) {
            $this->{$k} = $v;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param boolean $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getRolePermissionId()
    {
        return $this->rolePermissionId;
    }

    /**
     * @param int $rolePermissionId
     */
    public function setRolePermissionId($rolePermissionId)
    {
        $this->rolePermissionId = $rolePermissionId;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }


}
