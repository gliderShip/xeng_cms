<?php
namespace Xeng\Cms\CoreBundle\Services\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class PermissionManager {

    /** @var array $modules */
    private static $modules=[];

    /**
     * @param XAppModule $module
     */
    public static function addModule(XAppModule $module) {
        self::$modules[$module->getId()]=$module;
    }

    /**
     * @return array
     */
    public function getModules() {
        return self::$modules;
    }

    /**
     *
     * @param string $moduleId
     * @return ArrayCollection
     */
    public function getPermissions($moduleId) {
        if(isset(self::$modules[$moduleId])){
            /** @var XAppModule $module */
            $module=self::$modules[$moduleId];
            return $module->getChildren();
        } else {
            return null;
        }
    }

}