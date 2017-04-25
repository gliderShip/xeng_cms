<?php
namespace Xeng\Cms\AdminBundle\Config;

use Xeng\Cms\CoreBundle\Entity\Auth\XAppModule;
use Xeng\Cms\CoreBundle\Services\Auth\PermissionManager;

class AdminPermissionConfig {

    /**
     * adds permission configuration for core module
     */
    public static function configure() {
        $module = new XAppModule('xeng.admin', 'Admin Module');
        $module
            ->createChild('admin', 'Admin Area Access')->end();
        PermissionManager::addModule($module);
    }

}