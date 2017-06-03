<?php

// src/Xeng/Cms/AdminBundle/Controller/TestController.php

namespace Xeng\Cms\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Xeng\Cms\CoreBundle\Services\Content\ContentManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class TestController extends Controller
{
    /**
     * @Route("/test", name="admin.test")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request){
        /** @var ContentManager $contentManager */
        $contentManager = $this->get('xeng.content_manager');
        $result = $contentManager->findContentByCategory('opinion');

        // replace this example code with whatever you need
        return $this->render('XengCmsAdminBundle::test.html.twig', array(
            'result' => $result
        ));
    }
}
