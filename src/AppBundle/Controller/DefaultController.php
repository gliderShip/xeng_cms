<?php

// src/AppBundle/Controller/DefaultController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xeng\Cms\CoreBundle\Services\Content\NewsArticleManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class DefaultController extends Controller {

    /**
     * @Route("/article/{slug}", name="article")
     * @param Request $request
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction(Request $request,$slug) {
        /** @var NewsArticleManager $articleManager */
        $articleManager = $this->get('xeng.news_article_manager');
        $article=null;
        if(is_numeric($slug)){
            $article=$articleManager->getNewsArticle($slug);
        } else {
            $article=$articleManager->getNewsArticleBySlug($slug);
        }

        if(!$article){
            throw new NotFoundHttpException();
        }

        // replace this example code with whatever you need
        return $this->render('content/article.html.twig', array(
            'article' => $article,
            'contentCategories' => $article->getContentCategories()
        ));
    }


    /**
     * @Route("/", name="homepage")
     */
    public function homeAction() {
        // replace this example code with whatever you need
        return $this->render('home.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction() {
        // replace this example code with whatever you need
        return $this->render('pages/about.html.twig', array());
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction() {
        // replace this example code with whatever you need
        return $this->render('pages/contact.html.twig', array());
    }

}

