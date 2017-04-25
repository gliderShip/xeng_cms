<?php
namespace Xeng\Cms\CoreBundle\Services;

use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;
use Xeng\Cms\CoreBundle\Services\Auth\PermissionManager;

class PermissionConfig {

    /**
     * @param PermissionManager $permissionManager
     */
    public function __construct(PermissionManager $permissionManager) {
        $this->permissionManager = $permissionManager;
        $module = new XAppModule('xeng.core', 'Core Module');
        $module
            ->createChild('admin', 'Admin Area Access')->end()
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
            ->createChild('permissions.list', 'Permissions List')->end()
            ->createChild('permissions.update', 'Permissions Update')->end()
            ->end(); //end role permission node
        $permissionManager->addModule($module);
    }

}