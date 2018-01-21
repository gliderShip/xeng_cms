<?php

namespace AppBundle\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\Content\ContentManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class BlocksController extends Controller {


    /**
     * @param ContentManager $contentManager
     * @return Response
     */
    public function evidencedAction(ContentManager $contentManager) {
        $evidenced=$contentManager->findContentByCategory('evidenced',3);

        return $this->render('site/blocks/evidenced.html.twig', array(
            'evidenced'=>$evidenced
        ));
    }

    /**
     * @param ContentManager $contentManager
     * @param int $currentPage
     * @param int $pageSize
     * @return Response
     */
    public function mainArticlesAction(ContentManager $contentManager,$currentPage=1,$pageSize=30) {
        $pager=$contentManager->findContentByCategoryPaginated('kryesore',$currentPage,$pageSize);

        return $this->render('site/blocks/main_articles.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @param ContentManager $contentManager
     * @return Response
     */
    public function mostRecentAction(ContentManager $contentManager) {
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
