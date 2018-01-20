<?php

namespace AppBundle\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\Content\ContentManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class BlocksController extends Controller {

    public function evidencedAction() {

        /** @var ContentManager $contentManager */
        $contentManager=$this->get('xeng.content_manager');

        $evidenced=$contentManager->findContentByCategory('evidenced',3);

        return $this->render('site/blocks/evidenced.html.twig', array(
            'evidenced'=>$evidenced
        ));
    }

    public function mainArticlesAction($currentPage=1,$pageSize=30) {
        /** @var ContentManager $contentManager */
        $contentManager=$this->get('xeng.content_manager');

        $pager=$contentManager->findContentByCategoryPaginated('kryesore',$currentPage,$pageSize);
        return $this->render('site/blocks/main_articles.html.twig', array(
            'pager' => $pager
        ));
    }

    public function mostRecentAction() {
        /** @var ContentManager $contentManager */
        $contentManager=$this->get('xeng.content_manager');
        $recent=$contentManager->getLatestBaseContentList(7);
        return $this->render('site/blocks/most_recent.html.twig', array(
            'recent' => $recent
        ));
    }


    public function relatedAction() {

        return $this->render('site/blocks/related.html.twig', array(

        ));
    }

    public function followSocialAction() {

        return $this->render('site/blocks/follow_social.html.twig', array(

        ));
    }

    public function popularAction() {

        return $this->render('site/blocks/popular.html.twig', array(

        ));
    }

    public function reklamaAction() {

        return $this->render('site/blocks/reklama.html.twig', array(

        ));
    }

}
