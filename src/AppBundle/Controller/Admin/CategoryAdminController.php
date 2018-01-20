<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\Admin\Content\CategoryCreateHandler;
use AppBundle\Form\Admin\Content\CategoryEditHandler;
use AppBundle\Form\Base\ValidationResponse;
use AppBundle\Services\Content\CategoryManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/admin")
 * @Security("is_granted('p[x_admin.admin]')")
 */
class CategoryAdminController extends Controller {
    /**
     * @Route("/categories", name="xeng.admin.categories")
     * @Route("/categories/{currentPage}", name="xeng.admin.categories.page")
     * @Security("is_granted('p[x_core.category.list]')")
     *
     * @param int $currentPage
     * @return Response
     */
    public function categoriesAction($currentPage=1) {
        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->get('xeng.category_manager');

        $pager=$categoryManager->getAllCategories($currentPage,20);

        return $this->render('admin/category/categories.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/category/create", name="xeng.admin.category.create")
     * @Security("is_granted('p[x_core.category.create]')")
     *
     * @param Request $request
     * @return Response
     */
    public function createCategoryAction(Request $request) {

        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->get('xeng.category_manager');

        /** @var CategoryCreateHandler $formHandler */
        $formHandler = new CategoryCreateHandler($this->container,$request);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $categoryManager->createCategory(
                $validationResponse->getValue('name'),
                $validationResponse->getValue('label'),
                $validationResponse->getBooleanValue('hidden')
            );

            $this->addFlash(
                'notice',
                'Category was created succesfully!'
            );

            return $this->redirectToRoute('xeng.admin.categories');
        }

        return $this->render('admin/category/addCategory.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/category/edit/{categoryId}", name="xeng.admin.category.edit")
     * @Security("is_granted('p[x_core.category.update]')")
     *
     * @param Request $request
     * @param $categoryId
     * @return Response
     */
    public function editCategoryAction(Request $request,$categoryId) {

        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->get('xeng.category_manager');

        $category=$categoryManager->getCategory($categoryId);
        if(!$category){
            throw new NotFoundHttpException();
        }

        /** @var CategoryEditHandler $formHandler */
        $formHandler = new CategoryEditHandler($this->container,$request,$category);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $categoryManager->updateCategory($categoryId,
                $validationResponse->getValue('name'),
                $validationResponse->getValue('label'),
                $validationResponse->getBooleanValue('hidden')
            );

            $this->addFlash(
                'notice',
                'The category was updated succesfully!'
            );
        }

        return $this->render('admin/category/editCategory.html.twig', array(
            'category' => $category,
            'validationResponse' => $validationResponse
        ));
    }

}
