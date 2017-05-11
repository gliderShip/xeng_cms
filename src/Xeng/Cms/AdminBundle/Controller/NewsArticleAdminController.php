<?php

// src/Xeng/Cms/AdminBundle/Controller/NewsArticleAdminController.php

namespace Xeng\Cms\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xeng\Cms\AdminBundle\Form\Content\NewsArticleCreateHandler;
use Xeng\Cms\CoreBundle\Form\ValidationResponse;
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

            $article=$articleManager->createArticle(
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
    public function editArticleAction(Request $request,$nodeId) {

    }

}
