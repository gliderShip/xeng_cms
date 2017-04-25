<?php

// src/Xeng/Cms/CoreBundle/Entity/Auth/XAppModule.php

namespace Xeng\Cms\CoreBundle\Entity\Auth;


class XAppModule extends XPermission{

    /**
     * Constructor
     * @param string $id
     * @param string $name
     */
    public function __construct($id,$name) {
        parent::__construct($id,$name,true);
    }

}
