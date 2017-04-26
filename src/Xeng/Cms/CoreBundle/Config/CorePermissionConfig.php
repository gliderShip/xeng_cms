<?php
namespace Xeng\Cms\CoreBundle\Config;

use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;
use Xeng\Cms\CoreBundle\Services\Auth\PermissionManager;

class CorePermissionConfig {

    /**
     * adds permission configuration for core module
     */
    public static function configure() {
        $module = new XAppModule('x_core', 'Core Module');
        $module
            ->createChild('user', 'User', true)
                ->createChild('list', 'List')->end()
                ->createChild('detail', 'Detail')->end()
                ->createChild('create', 'Create')->end()
                ->createChild('update', 'Update')->end()
                ->createChild('delete', 'Delete')->end()
                ->createChild('profile', 'Profile')->end()
            ->end()//end user permission node
            ->createChild('role', 'Role', true)
                ->createChild('list', 'List')->end()
                ->createChild('detail', 'Detail')->end()
                ->createChild('create', 'Create')->end()
                ->createChild('update', 'Update')->end()
                ->createChild('delete', 'Delete')->end()
                ->createChild('permissions_list', 'Permissions List')->end()
                ->createChild('permissions_update', 'Permissions Update')->end()
            ->end(); //end role permission node
        PermissionManager::addModule($module);
    }

}