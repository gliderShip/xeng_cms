<?php

// src/AppBundle/Controller/DefaultController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xeng\Cms\CoreBundle\Services\Content\ContentManager;
use Xeng\Cms\CoreBundle\Services\Content\NewsArticleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class DefaultController extends Controller {
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('home.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/article/{slug}", name="article")
     */
    public function articleAction(Request $request,$slug) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=$articleManager->getNewsArticleBySlug($slug);
        if(!$article){
            throw new NotFoundHttpException();
        }

        /** @var ContentManager $contentManager */
        $contentManager = $this->get('xeng.content_manager');

        $categories=$contentManager->getContentCategories($article->getId());

        // replace this example code with whatever you need
        return $this->render('content/article.html.twig', array(
            'article' => $article,
            'categories' => $categories
        ));
    }
}
