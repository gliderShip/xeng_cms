<?php

// src/Xeng/Cms/CoreBundle/Controller/SecurityController.php

namespace Xeng\Cms\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class SecurityController extends Controller {
    /**
     * @Route("/logintest", name="logintest")
     * @return Response
     */
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
