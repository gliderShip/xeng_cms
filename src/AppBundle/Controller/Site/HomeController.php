<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Services\Content\NewsArticleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class HomeController extends Controller {

    /**
     * @Route("/article/{slug}", name="article")
     * @param $slug
     * @param NewsArticleManager $articleManager
     * @return Response
     */
    public function articleAction($slug, NewsArticleManager $articleManager) {
        $article=null;

        if(is_numeric($slug)){
            $article=$articleManager->getNewsArticle($slug);
        } else {
            $article=$articleManager->getNewsArticleBySlug($slug);
        }

        if(!$article){
            throw new NotFoundHttpException();
        }

        return $this->render('site/content/article.html.twig', array(
            'article' => $article,
            'contentCategories' => $article->getContentCategories()
        ));
    }


    /**
     * @Route("/", name="homepage")
     */
    public function homeAction() {
        return $this->render('site/home.html.twig', array());
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction() {
        return $this->render('site/pages/about.html.twig', array());
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction() {
        return $this->render('site/pages/contact.html.twig', array());
    }

}

