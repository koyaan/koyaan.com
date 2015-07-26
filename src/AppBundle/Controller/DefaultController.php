<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{

	/**
	 * @Route("/", name="index")
	 * @Template()
	 */
	public function indexAction() {

		return $this->forward("SonataNewsBundle:Post:archive", array(""));
	}


	/**
	 * @Route("/contact", name="contact")
	 * @Template()
	 */
	public function contactAction() {

		return array();
	}
}
