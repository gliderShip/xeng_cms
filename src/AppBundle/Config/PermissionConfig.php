<?php

namespace AppBundle\Config;

use AppBundle\Entity\Auth\XAppModule;
use AppBundle\Services\Auth\PermissionManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class PermissionConfig {

    /**
     * adds permission configuration for core module
     */
    public static function configure() {
        $module = new XAppModule('x_admin', 'Admin Module');
        $module
            ->createChild('admin', 'Admin Area Access')->end();
        PermissionManager::addModule($module);
        
        $module = new XAppModule('x_core', 'Core Module');
        $module
            ->createChild('user', 'User', true)
                ->createChild('list', 'List')->end()
                ->createChild('detail', 'Detail')->end()
                ->createChild('create', 'Create')->end()
                ->createChild('update', 'Update')->end()
                ->createChild('delete', 'Delete')->end()
                ->createChild('profile', 'Profile',true)
                    ->createChild('detail', 'Detail')->end()
                    ->createChild('update', 'Update')->end()
                ->end()//end profile permission node
                ->createChild('roles_update', 'Roles Update')->end()
            ->end()//end user permission node
            ->createChild('role', 'Role', true)
                ->createChild('list', 'List')->end()
                ->createChild('detail', 'Detail')->end()
                ->createChild('create', 'Create')->end()
                ->createChild('update', 'Update')->end()
                ->createChild('delete', 'Delete')->end()
                ->createChild('permissions_update', 'Permissions Update')->end()
            ->end() //end role permission node
            ->createChild('category', 'Category', true)
                ->createChild('list', 'List')->end()
                ->createChild('detail', 'Detail')->end()
                ->createChild('create', 'Create')->end()
                ->createChild('update', 'Update')->end()
                ->createChild('delete', 'Delete')->end()
            ->end() //end category permission node
            ->createChild('content', 'Content', true)
                ->createChild('article', 'News Article',true)
                    ->createChild('list', 'List')->end()
                    ->createChild('detail', 'Detail')->end()
                    ->createChild('create', 'Create')->end()
                    ->createChild('update', 'Update')->end()
                    ->createChild('delete', 'Delete')->end()
                ->end() //end article permission node
            ->end(); //end content permission node
        PermissionManager::addModule($module);
    }

}
