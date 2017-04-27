<?php

// src/Xeng/Cms/AdminBundle/Controller/DefaultController.php

namespace Xeng\Cms\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 * @Security("is_granted('p[x_admin.admin]')")
 */
class DefaultController extends Controller {
    /**
     * @Route("/", name="xeng.admin.home")
     */
    public function indexAction(Request $request){
        // replace this example code with whatever you need
        return $this->render('XengCmsAdminBundle::admin/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
}
