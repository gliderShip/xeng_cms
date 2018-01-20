<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\Admin\Auth\RoleCreateHandler;
use AppBundle\Form\Admin\Auth\RoleEditHandler;
use AppBundle\Form\Admin\Auth\RolePermissionsEditHandler;
use AppBundle\Form\Base\ValidationResponse;
use AppBundle\Services\Auth\PermissionManager;
use AppBundle\Services\Auth\XRoleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/admin")
 * @Security("is_granted('p[x_admin.admin]')")
 */
class RoleAdminController extends Controller {
    /**
     * @Route("/roles", name="xeng.admin.roles")
     * @Route("/roles/{currentPage}", name="xeng.admin.roles.page")
     * @Security("is_granted('p[x_core.role.list]')")
     *
     * @param int $currentPage
     * @return Response
     */
    public function rolesAction($currentPage=1) {
        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        $pager=$xRoleManager->getAllRoles($currentPage,20);

        return $this->render('admin/role/roles.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/role/create", name="xeng.admin.role.create")
     * @Security("is_granted('p[x_core.role.create]')")
     *
     * @param Request $request
     * @return Response
     */
    public function createRoleAction(Request $request) {

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        /** @var RoleCreateHandler $formHandler */
        $formHandler = new RoleCreateHandler($this->container,$request);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $xRoleManager->createRole(
                $validationResponse->getValue('name'),
                $validationResponse->getValue('description'),
                $validationResponse->getBooleanValue('enabled')
            );

            $this->addFlash(
                'notice',
                'The role was created succesfully!'
            );
            return $this->redirectToRoute('xeng.admin.roles');
        }

        return $this->render('admin/role/addRole.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/role/edit/{roleId}", name="xeng.admin.role.edit")
     * @Security("is_granted('p[x_core.role.update]')")
     *
     * @param Request $request
     * @param $roleId
     * @return Response
     */
    public function editRoleAction(Request $request,$roleId) {

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        $role=$xRoleManager->getRole($roleId);
        if(!$role){
            throw new NotFoundHttpException();
        }

        /** @var RoleEditHandler $formHandler */
        $formHandler = new RoleEditHandler($this->container,$request,$role);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $xRoleManager->updateRole($roleId,
                $validationResponse->getValue('name'),
                $validationResponse->getValue('description'),
                $validationResponse->getBooleanValue('enabled')
            );

            $this->addFlash(
                'notice',
                'The role was updated succesfully!'
            );
        }

        return $this->render('admin/role/editRoleGeneral.html.twig', array(
            'role' => $role,
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/role/edit/permissions/{roleId}", name="xeng.admin.role.edit.permissions")
     * @Security("is_granted('p[x_core.role.permissions_update]')")
     *
     * @param Request $request
     * @param $roleId
     * @return Response
     */
    public function editRolePermissionsAction(Request $request,$roleId) {
        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        $role=$xRoleManager->getRole($roleId);
        if(!$role){
            throw new NotFoundHttpException();
        }

        /** @var PermissionManager $permissionManager */
        $permissionManager = $this->get('xeng.permission_manager');

        $permissionModules = $permissionManager->getModules();


        /** @var RolePermissionsEditHandler $formHandler */
        $formHandler = new RolePermissionsEditHandler($this->container,$request,$role);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $xRoleManager->deleteRolePermissions($formHandler->getToBeDeleted());
            $xRoleManager->addRolePermissions($role,$formHandler->getToBeAdded());
            $this->addFlash(
                'notice',
                'Role permissions updated successfully!'
            );
        }

        return $this->render('admin/role/editRolePermissions.html.twig', array(
            'role' => $role,
            'permissionModules' => $permissionModules,
            'validationResponse' => $validationResponse
        ));
    }

}
