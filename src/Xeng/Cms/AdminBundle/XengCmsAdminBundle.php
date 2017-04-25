<?php

// src/Xeng/Cms/AdminBundle/XengCmsAdminBundle.php

namespace  Xeng\Cms\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Xeng\Cms\AdminBundle\Config\AdminPermissionConfig;

class XengCmsAdminBundle extends Bundle {
    /**
     * Boots the Bundle.
     */
    public function boot(){
        AdminPermissionConfig::configure();
    }
}
