<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\Admin\Content\ContentCategoryEditHandler;
use AppBundle\Form\Admin\Content\ContentImageUploadHandler;
use AppBundle\Form\Admin\Content\NewsArticleCreateHandler;
use AppBundle\Form\Admin\Content\NewsArticleEditHandler;
use AppBundle\Services\Content\CategoryManager;
use AppBundle\Services\Content\ContentImageManager;
use AppBundle\Services\Content\ContentManager;
use AppBundle\Services\Content\NewsArticleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/admin/content")
 * @Security("is_authenticated()")
 */
class NewsArticleAdminController extends Controller {
    /**
     * @Route("/article/list", name="xeng.admin.content.article.list")
     * @Route("/article/list/{currentPage}", name="xeng.admin.content.article.list.page")
     * @Security("is_granted('p[x_core.content.article.list]')")
     *
     * @param NewsArticleManager $articleManager
     * @param int $currentPage
     * @return Response
     */
    public function articleListAction(NewsArticleManager $articleManager, $currentPage=1) {
        $pager=$articleManager->getAllNewsArticle($currentPage,20);

        return $this->render('admin/content/article/articleList.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/article/create", name="xeng.admin.content.article.create")
     * @Security("is_granted('p[x_core.content.article.create]')")
     *
     * @param Request $request
     * @param NewsArticleManager $articleManager
     * @return Response
     */
    public function createArticleAction(Request $request, NewsArticleManager $articleManager) {

        $formHandler = new NewsArticleCreateHandler($this->container,$request);
        $formHandler->handle();

        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){

            $articleManager->createArticle(
                $this->getUser(),
                $validationResponse->getStringValue('title'),
                $validationResponse->getStringValue('summary'),
                $validationResponse->getStringValue('body')
            );

            $this->addFlash(
                'notice',
                'News Article created successfully!'
            );

            return $this->redirectToRoute('xeng.admin.content.article.list');
        }

        return $this->render('admin/content/article/articleCreate.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }


    /**
     * @Route("/article/edit/{nodeId}", name="xeng.admin.content.article.edit")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param Request $request
     * @param $nodeId
     * @param NewsArticleManager $articleManager
     * @param ContentImageManager $imageManager
     * @return Response
     */
    public function editArticleGeneralAction(Request $request, $nodeId, NewsArticleManager $articleManager, ContentImageManager $imageManager) {
        $article=$articleManager->getNewsArticle($nodeId);

        if(!$article){
            throw new NotFoundHttpException();
        }

        $formHandler = new NewsArticleEditHandler($this->container,$request,$article);
        $formHandler->handle();

        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){

            $articleManager->updateArticle(
                $article,
                $validationResponse->getStringValue('title'),
                $validationResponse->getStringValue('summary'),
                $validationResponse->getStringValue('body'),
                $validationResponse->getValue('status')
            );

            /** @var UploadedFile $uploadedFile */
            $uploadedFile=$validationResponse->getValue('image');
            if($uploadedFile){

                $image=$imageManager->addContentImage($article,$uploadedFile);
                if($image){
                    $articleManager->setArticleImage($article,$image,true);
                }
            }


            $this->addFlash(
                'notice',
                'News Article updated successfully!'
            );

        }

        $images=$imageManager->getContentImages($nodeId);

        return $this->render('admin/content/article/articleEditGeneral.html.twig', array(
            'article' => $article,
            'images' => $images,
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/article/edit/{nodeId}/images", name="xeng.admin.content.article.edit.images")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param Request $request
     * @param $nodeId
     * @param NewsArticleManager $articleManager
     * @param ContentImageManager $imageManager
     * @return Response
     */
    public function articleEditImagesListAction(Request $request, $nodeId, NewsArticleManager $articleManager, ContentImageManager $imageManager) {
        $article=$articleManager->getNewsArticle($nodeId);

        if(!$article){
            throw new NotFoundHttpException();
        }

        $formHandler = new ContentImageUploadHandler($this->container,$request);
        $formHandler->handle();

        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){

            /** @var UploadedFile $uploadedFile */
            $uploadedFile=$validationResponse->getValue('image');
            if($uploadedFile){
                $imageManager->addContentImage($article,$uploadedFile);
            }

            $this->addFlash(
                'notice',
                'Image uploaded successfully!'
            );

        }

        $images=$imageManager->getContentImages($nodeId);

        return $this->render('admin/content/article/articleEditImages.html.twig', array(
            'article' => $article,
            'images' => $images,
            'validationResponse' => $validationResponse
        ));
    }

    /**
     * @Route("/article/edit/{nodeId}/images/default/{imageId}", name="xeng.admin.content.article.edit.images.default")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param $nodeId
     * @param $imageId
     * @param NewsArticleManager $articleManager
     * @param ContentImageManager $imageManager
     * @return Response
     */
    public function articleEditImagesDefaultAction($nodeId, $imageId, NewsArticleManager $articleManager, ContentImageManager $imageManager) {
        $article=$articleManager->getNewsArticle($nodeId);

        if(!$article){
            throw new NotFoundHttpException();
        }

        $image=$imageManager->getImage($imageId);
        if(!$image){
            throw new NotFoundHttpException();
        }

        $articleManager->setArticleImage($article,$image,true);

        return $this->redirectToRoute('xeng.admin.content.article.edit.images', array(
            'nodeId' => $article->getId()
        ));
    }

    /**
     * @Route("/article/edit/{nodeId}/images/delete/{imageId}", name="xeng.admin.content.article.edit.images.delete")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param $nodeId
     * @param $imageId
     * @param NewsArticleManager $articleManager
     * @param ContentImageManager $imageManager
     * @return Response
     */
    public function articleEditImagesDeleteAction($nodeId, $imageId, NewsArticleManager $articleManager, ContentImageManager $imageManager) {
        $article=$articleManager->getNewsArticle($nodeId);

        if(!$article){
            throw new NotFoundHttpException();
        }

        $image=$imageManager->getImage($imageId);

        if(!$image){
            throw new NotFoundHttpException();
        }

        $articleManager->setArticleImage($article,null,true);
        $imageManager->deleteImage($image);

        return $this->redirectToRoute('xeng.admin.content.article.edit.images', array(
            'nodeId' => $article->getId()
        ));
    }

    /**
     * @Route("/article/edit/category/{nodeId}", name="xeng.admin.content.article.edit.category")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param Request $request
     * @param $nodeId
     * @param NewsArticleManager $articleManager
     * @param CategoryManager $categoryManager
     * @param ContentManager $contentManager
     * @return Response
     */
    public function editArticleCategoryAction(Request $request, $nodeId,
                                              NewsArticleManager $articleManager,
                                              CategoryManager $categoryManager,
                                              ContentManager $contentManager) {
        $article=$articleManager->getNewsArticle($nodeId);

        if(!$article){
            throw new NotFoundHttpException();
        }

        $categories=$categoryManager->getAllCategories()->getResults();

        $formHandler = new ContentCategoryEditHandler($this->container,$request,$article,$categories);
        $formHandler->handle();

        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $contentManager->deleteContentCategories($formHandler->getToBeDeleted());
            $contentManager->addContentCategories($article,$formHandler->getToBeAdded());
            $this->addFlash(
                'notice',
                'Article categories updated successfully!'
            );
        }

        return $this->render('admin/content/article/articleEditCategories.html.twig', array(
            'article' => $article,
            'categories' => $categories,
            'validationResponse' => $validationResponse
        ));
    }
}
