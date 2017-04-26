<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/RolePermissionsEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Auth\XRole;
use Xeng\Cms\CoreBundle\Form\FormHandler;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit role permissions form handler
 */
class RolePermissionsEditHandler extends FormHandler {
    /** @var XRole $role */
    protected $role;
    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XRole $role
     */
    public function __construct(ContainerInterface $container, Request $request, XRole $role) {
        parent::__construct($container,$request);
        $this->role=$role;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();



        if(!$this->isSubmitted()){

            return;
        }


    }

}