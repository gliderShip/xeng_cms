<?php

namespace AppBundle\Controller\Site;

use AppBundle\Exception\CategoryNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\Content\ContentManager;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;


/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class BlocksController extends Controller
{
    /**
     * @param ContentManager $contentManager
     * @return Response
     */
    public function evidencedAction(ContentManager $contentManager, LoggerInterface $logger)
    {
        $evidenced = null;
        try {
            $evidenced = $contentManager->findContentByCategory('evidenced', 3);
        } catch (CategoryNotFoundException $ex) {
            // TODO: just log for now
            $logger->error("An error occurred:{$ex->getMessage()}");
        }

        return $this->render(
            'site/blocks/evidenced.html.twig',
            array(
                'evidenced' => $evidenced,
            )
        );
    }

    /**
     * @param ContentManager $contentManager
     * @param int $currentPage
     * @param int $pageSize
     * @return Response
     */
    public function mainArticlesAction(ContentManager $contentManager, $currentPage = 1, $pageSize = 30, LoggerInterface $logger)
    {
        $pager = null;
        try {
            $pager = $contentManager->findContentByCategoryPaginated('kryesore', $currentPage, $pageSize);
        } catch (CategoryNotFoundException $ex) {
            // TODO: just log for now
            $logger->error("An error occurred:{$ex->getMessage()}");
        }

        return $this->render(
            'site/blocks/main_articles.html.twig',
            array(
                'pager' => $pager,
            )
        );
    }

    /**
     * @param ContentManager $contentManager
     * @return Response
     */
    public function mostRecentAction(ContentManager $contentManager)
    {
        $recent = $contentManager->getLatestBaseContentList(7);

        return $this->render(
            'site/blocks/most_recent.html.twig',
            array(
                'recent' => $recent,
            )
        );
    }


    public function relatedAction()
    {

        return $this->render(
            'site/blocks/related.html.twig',
            array()
        );
    }

    public function followSocialAction()
    {

        return $this->render(
            'site/blocks/follow_social.html.twig',
            array()
        );
    }

    public function popularAction()
    {

        return $this->render(
            'site/blocks/popular.html.twig',
            array()
        );
    }

    public function reklamaAction()
    {

        return $this->render(
            'site/blocks/reklama.html.twig',
            array()
        );
    }

}
