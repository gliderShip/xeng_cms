<?php

// src/Xeng/Cms/AdminBundle/Form/Auth/UserRolesEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Auth;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Form\FormHandler;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit role permissions form handler
 */
class UserRolesEditHandler extends FormHandler {
    /** @var XUser $user */
    protected $user;

    /** @var array $roles */
    protected $roles;

    /** @var array $toBeDeleted */
    protected $toBeDeleted;

    /** @var array $toBeAdded */
    protected $toBeAdded;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param XUser $user
     * @param array $roles
     */
    public function __construct(ContainerInterface $container, Request $request, XUser $user, $roles) {
        parent::__construct($container,$request);
        $this->user=$user;
        $this->roles=$roles;
        $this->toBeAdded=array();
        $this->toBeDeleted=array();
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        if($this->isSubmitted()){



        } else {

        }

    }

    /**
     * @return array
     */
    public function getToBeDeleted(){
        return $this->toBeDeleted;
    }

    /**
     * @return array
     */
    public function getToBeAdded(){
        return $this->toBeAdded;
    }

}