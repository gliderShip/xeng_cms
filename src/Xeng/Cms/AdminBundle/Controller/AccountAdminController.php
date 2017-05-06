<?php

// src/Xeng/Cms/AdminBundle/Controller/AccountAdminController.php

namespace Xeng\Cms\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xeng\Cms\AdminBundle\Form\Account\UserProfileEditHandler;
use Xeng\Cms\AdminBundle\Form\Auth\UserCreateHandler;
use Xeng\Cms\AdminBundle\Form\Auth\UserEditHandler;
use Xeng\Cms\AdminBundle\Form\Auth\UserRolesEditHandler;
use Xeng\Cms\CoreBundle\Entity\Account\Profile;
use Xeng\Cms\CoreBundle\Form\ValidationResponse;
use Xeng\Cms\CoreBundle\Services\Account\ProfileManager;
use Xeng\Cms\CoreBundle\Services\Auth\XRoleManager;
use Xeng\Cms\CoreBundle\Services\Auth\XUserManager;
use Xeng\Cms\CoreBundle\Util\MemoryLogger;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 */
class AccountAdminController extends Controller {
    /**
     * @Route("/account", name="xeng.admin.account")
     *
     * @return Response
     */
    public function accountAction() {
        return $this->render('XengCmsAdminBundle::account/account.html.twig', array(

        ));
    }

}
