<?php

// src/AppBundle/Controller/DefaultController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/article", name="article")
     */
    public function articleAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('content/article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
}
