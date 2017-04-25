<?php

// src/Xeng/Cms/AdminBundle/Controller/RoleAdminController.php

namespace Xeng\Cms\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xeng\Cms\AdminBundle\Form\Auth\RoleCreateHandler;
use Xeng\Cms\AdminBundle\Form\Auth\RoleEditHandler;
use Xeng\Cms\CoreBundle\Form\ValidationResponse;
use Xeng\Cms\CoreBundle\Services\Auth\PermissionManager;
use Xeng\Cms\CoreBundle\Services\Auth\XRoleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class RoleAdminController extends Controller {
    /**
     * @Route("/roles", name="xeng.admin.roles")
     * @Route("/roles/{currentPage}", name="xeng.admin.roles.page")
     *
     * @param int $currentPage
     * @return Response
     */
    public function rolesAction($currentPage=1) {
        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        /** @var PermissionManager $permissionManager */
        $permissionManager = $this->get('xeng.permission_manager');

        $pager=$xRoleManager->getAllRoles($currentPage,20);

        return $this->render('XengCmsAdminBundle::admin/role/roles.html.twig', array(
            'pager' => $pager,
            'modules' => $permissionManager->getModules()
        ));
    }

    /**
     * @Route("/role/create", name="xeng.admin.role.create")
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

        return $this->render('XengCmsAdminBundle::admin/role/addRole.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/role/edit/{roleId}", name="xeng.admin.role.edit")
     *
     * @param Request $request
     * @param $roleId
     * @return Response
     */
    public function editUserAction(Request $request,$roleId) {

        /** @var XRoleManager $xRoleManager */
        $xRoleManager = $this->get('xeng.role_manager');

        $role=$xRoleManager->getRole($roleId);

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

        return $this->render('XengCmsAdminBundle::admin/role/editRoleGeneral.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

}
