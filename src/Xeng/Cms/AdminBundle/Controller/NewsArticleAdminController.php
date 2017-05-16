<?php

// src/Xeng/Cms/AdminBundle/Controller/NewsArticleAdminController.php

namespace Xeng\Cms\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xeng\Cms\AdminBundle\Form\Content\ContentCategoryEditHandler;
use Xeng\Cms\AdminBundle\Form\Content\ContentImageUploadHandler;
use Xeng\Cms\AdminBundle\Form\Content\NewsArticleCreateHandler;
use Xeng\Cms\AdminBundle\Form\Content\NewsArticleEditHandler;
use Xeng\Cms\CoreBundle\Form\ValidationResponse;
use Xeng\Cms\CoreBundle\Services\Content\CategoryManager;
use Xeng\Cms\CoreBundle\Services\Content\ContentImageManager;
use Xeng\Cms\CoreBundle\Services\Content\ContentManager;
use Xeng\Cms\CoreBundle\Services\Content\NewsArticleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/content")
 * @Security("is_authenticated()")
 */
class NewsArticleAdminController extends Controller {
    /**
     * @Route("/article/list", name="xeng.admin.content.article.list")
     * @Route("/article/list/{currentPage}", name="xeng.admin.content.article.list.page")
     * @Security("is_granted('p[x_core.content.article.list]')")
     *
     * @param int $currentPage
     * @return Response
     */
    public function articleListAction($currentPage=1) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');

        $pager=$articleManager->getAllNewsArticle($currentPage,20);

        return $this->render('XengCmsAdminBundle::content/article/articleList.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @Route("/article/create", name="xeng.admin.content.article.create")
     * @Security("is_granted('p[x_core.content.article.create]')")
     *
     * @param Request $request
     * @return Response
     */
    public function createArticleAction(Request $request) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');


        /** @var NewsArticleCreateHandler $formHandler */
        $formHandler = new NewsArticleCreateHandler($this->container,$request);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
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

        return $this->render('XengCmsAdminBundle::content/article/articleCreate.html.twig', array(
            'validationResponse' => $validationResponse
        ));
    }


    /**
     * @Route("/article/edit/{nodeId}", name="xeng.admin.content.article.edit")
     * @Security("is_granted('p[x_core.content.article.update]')")
     *
     * @param Request $request
     * @param $nodeId
     * @return Response
     */
    public function editArticleGeneralAction(Request $request,$nodeId) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticle($nodeId);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var ContentImageManager $imageManager */
        $imageManager = $this->get('xeng.content_image_manager');

        /** @var NewsArticleEditHandler $formHandler */
        $formHandler = new NewsArticleEditHandler($this->container,$request,$article);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){

            $articleManager->updateArticle(
                $article,
                $validationResponse->getStringValue('title'),
                $validationResponse->getStringValue('summary'),
                $validationResponse->getStringValue('body')
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

        return $this->render('XengCmsAdminBundle::content/article/articleEditGeneral.html.twig', array(
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
     * @return Response
     */
    public function articleEditImagesListAction(Request $request,$nodeId) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticle($nodeId);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var ContentImageManager $imageManager */
        $imageManager = $this->get('xeng.content_image_manager');

        /** @var ContentImageUploadHandler $formHandler */
        $formHandler = new ContentImageUploadHandler($this->container,$request);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        if($formHandler->isSubmitted() && $formHandler->isValid()){

            /** @var UploadedFile $uploadedFile */
            $uploadedFile=$validationResponse->getValue('image');
            if($uploadedFile){
                /** @var ContentImageManager $imageManager */
                $imageManager = $this->get('xeng.content_image_manager');
                $imageManager->addContentImage($article,$uploadedFile);
            }

            $this->addFlash(
                'notice',
                'Image uploaded successfully!'
            );

        }

        $images=$imageManager->getContentImages($nodeId);

        return $this->render('XengCmsAdminBundle::content/article/articleEditImages.html.twig', array(
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
     * @return Response
     */
    public function articleEditImagesDefaultAction($nodeId,$imageId) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticle($nodeId);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var ContentImageManager $imageManager */
        $imageManager = $this->get('xeng.content_image_manager');
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
     * @return Response
     */
    public function articleEditImagesDeleteAction($nodeId,$imageId) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticle($nodeId);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var ContentImageManager $imageManager */
        $imageManager = $this->get('xeng.content_image_manager');
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
     * @return Response
     */
    public function editArticleCategoryAction(Request $request,$nodeId) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticle($nodeId);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->get('xeng.category_manager');
        $categories=$categoryManager->getAllCategories()->getResults();

        /** @var ContentCategoryEditHandler $formHandler */
        $formHandler = new ContentCategoryEditHandler($this->container,$request,$article,$categories);
        $formHandler->handle();

        /** @var ValidationResponse $validationResponse */
        $validationResponse=$formHandler->getValidationResponse();

        /** @var ContentManager $contentManager */
        $contentManager = $this->get('xeng.content_manager');

        if($formHandler->isSubmitted() && $formHandler->isValid()){
            $contentManager->deleteContentCategories($formHandler->getToBeDeleted());
            $contentManager->addContentCategories($article,$formHandler->getToBeAdded());
            $this->addFlash(
                'notice',
                'Article categories updated successfully!'
            );
        }


        return $this->render('XengCmsAdminBundle::content/article/articleEditCategories.html.twig', array(
            'article' => $article,
            'categories' => $categories,
            'validationResponse' => $validationResponse
        ));
    }
}
