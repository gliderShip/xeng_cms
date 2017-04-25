<?php

// src/Xeng/Cms/CoreBundle/XengCmsCoreBundle.php

namespace Xeng\Cms\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Xeng\Cms\CoreBundle\Config\CorePermissionConfig;

class XengCmsCoreBundle extends Bundle {
    /**
     * Boots the Bundle.
     */
    public function boot(){
        CorePermissionConfig::configure();
    }

}
