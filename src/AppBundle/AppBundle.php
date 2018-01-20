<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Config\PermissionConfig;

class AppBundle extends Bundle {
    
    /**
     * Boots the Bundle.
     */
    public function boot(){
        PermissionConfig::configure();
    }

}
