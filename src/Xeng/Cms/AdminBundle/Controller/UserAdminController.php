<?php

// src/Xeng/Cms/AdminBundle/Controller/UserAdminController.php

namespace Xeng\Cms\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xeng\Cms\AdminBundle\Form\Auth\UserCreateHandler;
use Xeng\Cms\AdminBundle\Form\Auth\UserEditHandler;
use Xeng\Cms\CoreBundle\Form\ValidationResponse;
use Xeng\Cms\CoreBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class UserAdminController extends Controller {
    /**
     * @Route("/users", name="xeng.admin.users")
     * @Route("/users/{currentPage}", name="xeng.admin.users.page")
     *
     * @param int $currentPage
     * @return Response
     */
    public function usersAction($currentPage=1) {
        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');

        $pager=$xUserManager->getAllUsers($currentPage,20);

        return $this->render('XengCmsAdminBundle::admin/user/users.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/user/create", name="xeng.admin.user.create")
     *
     * @param Request $request
     * @return Response
     */
    public function createUserAction(Request $request) {

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');

        /** @var UserCreateHandler $formHandler */
        $formHandler = new UserCreateHandler($this->container,$request);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $xUserManager->createUser(
                $validationResponse->getValue('username'),
                $validationResponse->getValue('email'),
                $validationResponse->getValue('password'),
                $validationResponse->getBooleanValue('enabled')
            );

            $this->addFlash(
                'notice',
                'The user was created succesfully!'
            );

            return $this->redirectToRoute('xeng.admin.users');
        }

        return $this->render('XengCmsAdminBundle::admin/user/addUser.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/user/edit/{userId}", name="xeng.admin.user.edit")
     *
     * @param Request $request
     * @param $userId
     * @return Response
     */
    public function editUserAction(Request $request,$userId) {

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');

        $user=$xUserManager->getUser($userId);

        /** @var UserEditHandler $formHandler */
        $formHandler = new UserEditHandler($this->container,$request,$user);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $newPassword=null;
            if(!$validationResponse->getParam('password')->isEmpty()){
                $newPassword=$validationResponse->getStringValue('password');
            }
            $xUserManager->updateUser($userId,
                $validationResponse->getValue('username'),
                $validationResponse->getValue('email'),
                $validationResponse->getBooleanValue('enabled'),
                $newPassword
            );

            $this->addFlash(
                'notice',
                'The user was updated succesfully!'
            );
        }

        return $this->render('XengCmsAdminBundle::admin/user/editUserGeneral.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

}
