<?php
namespace Xeng\Cms\CoreBundle\Services\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;

class PermissionManager {

    /** @var array $modules */
    private $modules;

    public function __construct(){
        $this->modules=[];
    }

    /**
     * @param XAppModule $module
     */
    public function addModule(XAppModule $module) {
        $this->modules[$module->getId()]=$module;
    }

    /**
     * @return array
     */
    public function getModules() {
        return $this->modules;
    }

    /**
     *
     * @param string $moduleId
     * @return ArrayCollection
     */
    public function getPermissions($moduleId) {
        if(isset($this->modules[$moduleId])){
            /** @var XAppModule $module */
            $module=$this->modules[$moduleId];
            return $module->getChildren();
        } else {
            return null;
        }
    }

}