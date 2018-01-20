<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\Admin\Account\UserProfileEditHandler;
use AppBundle\Form\Admin\Auth\UserCreateHandler;
use AppBundle\Form\Admin\Auth\UserEditHandler;
use AppBundle\Form\Admin\Auth\UserRolesEditHandler;
use AppBundle\Entity\Account\Profile;
use AppBundle\Form\Base\ValidationResponse;
use AppBundle\Services\Account\ProfileManager;
use AppBundle\Services\Auth\XRoleManager;
use AppBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/admin")
 * @Security("is_granted('p[x_admin.admin]')")
 */
class UserAdminController extends Controller {
    /**
     * @Route("/users", name="xeng.admin.users")
     * @Route("/users/{currentPage}", name="xeng.admin.users.page")
     * @Security("is_granted('p[x_core.user.list]')")
     *
     * @param int $currentPage
     * @return Response
     */
    public function usersAction($currentPage=1) {
        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');

        $pager=$xUserManager->getAllUsers($currentPage,20);

        return $this->render('admin/user/users.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/user/create", name="xeng.admin.user.create")
     * @Security("is_granted('p[x_core.user.create]')")
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

        return $this->render('admin/user/addUser.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/user/edit/{userId}", name="xeng.admin.user.edit")
     * @Security("is_granted('p[x_core.user.update]')")
     *
     * @param Request $request
     * @param $userId
     * @return Response
     */
    public function editUserAction(Request $request,$userId) {

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');

        $user=$xUserManager->getUser($userId);
        if(!$user){
            throw new NotFoundHttpException();
        }

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

        return $this->render('admin/user/editUserGeneral.html.twig', array(
            'user' => $user,
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/user/edit/roles/{userId}", name="xeng.admin.user.edit.roles")
     * @Security("is_granted('p[x_core.user.roles_update]')")
     *
     * @param Request $request
     * @param $userId
     * @return Response
     */
    public function editUserRolesAction(Request $request,$userId) {

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');
        $user=$xUserManager->getUser($userId);
        if(!$user){
            throw new NotFoundHttpException();
        }
        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');
        $roles=$xRoleManager->getAllRoles()->getResults();

        /** @var UserRolesEditHandler $formHandler */
        $formHandler = new UserRolesEditHandler($this->container,$request,$user,$roles);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $xUserManager->deleteUserRoles($formHandler->getToBeDeleted());
            $xUserManager->addUserRoles($user,$formHandler->getToBeAdded());
            $this->addFlash(
                'notice',
                'User roles updated successfully!'
            );
        }

        return $this->render('admin/user/editUserRoles.html.twig', array(
            'user' => $user,
            'roles' => $roles,
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/user/edit/profile/{userId}", name="xeng.admin.user.edit.profile")
     * @Security("is_granted('p[x_core.user.profile.update]')")
     *
     * @param Request $request
     * @param int $userId
     * @return Response
     */
    public function editUserProfileAction(Request $request,$userId) {

        /** @var XUserManager $xUserManager */
        $xUserManager = $this->get('xeng.user_manager');
        $user=$xUserManager->getUser($userId);
        if(!$user){
            throw new NotFoundHttpException();
        }


        /** @var ProfileManager $profileManager */
        $profileManager = $this->get('xeng.account.profile_manager');
        /** @var Profile $profile */
        $profile=$profileManager->getProfileByUser($userId);
        $newProfile=false;
        if(!$profile){
            $profile=new Profile();
            $newProfile=true;
        }

        /** @var UserProfileEditHandler $formHandler */
        $formHandler = new UserProfileEditHandler($this->container,$request,$profile);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $p=null;
            if($newProfile){
                $p=$profileManager->createProfile(
                    $user,
                    $validationResponse->getValue('firstName'),
                    $validationResponse->getValue('lastName')
                );
                $newProfile=false;
                $this->addFlash(
                    'notice',
                    'Profile created successfully!'
                );
            } else {
                $p=$profileManager->updateProfile(
                    $profile->getId(),
                    $validationResponse->getValue('firstName'),
                    $validationResponse->getValue('lastName')
                );
                $this->addFlash(
                    'notice',
                    'Profile updated successfully!'
                );
            }

            /** @var UploadedFile $uploadedFile */
            $uploadedFile=$validationResponse->getValue('profileImage');
            if($p && $uploadedFile){
                $profile=$p;
                $profileManager->updateProfileImage($p,$uploadedFile);
            }

        }

        return $this->render('admin/user/editUserProfile.html.twig', array(
            'user' => $user,
            'newProfile' => $newProfile,
            'profile' => $profile,
            'validationResponse' => $validationResponse
        ));
    }

}
