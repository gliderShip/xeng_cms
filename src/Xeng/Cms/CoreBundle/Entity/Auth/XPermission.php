<?php

// src/Xeng/Cms/CoreBundle/Entity/Auth/XPermission.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;

class XPermission {
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var boolean $abstract
     */
    protected $abstract=false;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var ArrayCollection $children
     */
    protected $children;

    /**
     * @var XPermission $parent
     */
    protected $parent;

    /**
     * @var boolean $enabled
     */
    protected $enabled=false;
    /**
     * @var int $rolePermissionId
     */
    protected $rolePermissionId=-1;

    /**
     * Constructor
     * @param string $id
     * @param string $name
     * @param bool $abstract
     */
    public function __construct($id,$name,$abstract=false) {
        $this->id = $id;
        $this->name = $name;
        $this->abstract = $abstract;
        $this->children = new ArrayCollection();
        $this->parent = null;
    }

    /**
     * @return string
     */
    public function getFullId() {
        if($this->parent!==null && !($this->parent instanceof XAppModule)){
            return $this->parent->getFullId().'.'.$this->id;
        } else {
            return $this->id;
        }
    }

    /**
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAbstract(){
        return $this->abstract;
    }

    /**
     * @param boolean $abstract
     * @return $this
     */
    public function setAbstract($abstract){
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled(){
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getRolePermissionId(){
        return $this->rolePermissionId;
    }

    /**
     * @param int $rolePermissionId
     */
    public function setRolePermissionId($rolePermissionId) {
        $this->rolePermissionId = $rolePermissionId;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren(){
        return $this->children;
    }

    /**
     * @param $id
     * @param $name
     * @param bool $abstract
     * @return XPermission
     */
    public function createChild($id, $name, $abstract=false) {
        /** @var XPermission $child */
        $child=new XPermission($id,$name,$abstract);
        $child->setParent($this);
        $this->children->add($child);
        return $child;
    }

    /**
     * Convenience method to help with the configuration
     * @return XPermission
     */
    public function end() {
        return $this->parent;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children) {
        $this->children = $children;
    }

    /**
     * @return XPermission
     */
    public function getParent(){
        return $this->parent;
    }

    /**
     * @param XPermission $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }


}
