<?php

namespace Koyaan\BsBotBundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {   
        return array();
    }

    /**
     * @Route("/admin/")
     * @Template()
     */
    public function adminAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return(array('user' => $user));
    }
}
