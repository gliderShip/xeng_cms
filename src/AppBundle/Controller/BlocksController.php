<?php

// src/AppBundle/Controller/BlocksController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class BlocksController extends Controller {

    public function evidencedAction() {

        return $this->render('blocks/evidenced.html.twig', array(

        ));
    }

    public function relatedAction() {

        return $this->render('blocks/related.html.twig', array(

        ));
    }

    public function followSocialAction() {

        return $this->render('blocks/follow_social.html.twig', array(

        ));
    }

    public function latestArticlesAction() {

        return $this->render('blocks/latest_articles.html.twig', array(

        ));
    }

    public function mostRecentAction() {

        return $this->render('blocks/most_recent.html.twig', array(

        ));
    }

    public function popularAction() {

        return $this->render('blocks/popular.html.twig', array(

        ));
    }

    public function reklamaAction() {

        return $this->render('blocks/reklama.html.twig', array(

        ));
    }



}
