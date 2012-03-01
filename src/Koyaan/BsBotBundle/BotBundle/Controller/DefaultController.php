<?php

namespace Koyaan\BsBotBundle\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/botindex")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/connectTwitter", name="connectTwitter")
     *
     */
    public function connectTwitterAction() {
        $request = $this->get('request');
        $twitter = $this->get('fos_twitter.service');

        $authURL = $twitter->getLoginUrl($request);

        $response = new RedirectResponse($authURL);

        return $response;
    }
   
}
