<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * @Route("/admin")
 * @Security("is_authenticated()")
 */
class HomeController extends Controller {
    /**
     * @Route("", name="xeng.admin.home")
     */
    public function indexAction(){
        return $this->render('admin/index.html.twig');
    }
}
