<?php

namespace Koyaan\GlobeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Koyaan\GlobeBundle\Entity\Globe;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Globe controller.
 *
 * @Route("/squareglobe")
 */
class GlobeController extends Controller
{
    /**
     * Lists all Globe entities.
     *
     * @Route("/list", name="squareglobe")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KoyaanGlobeBundle:Globe')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Globe entity.
     *
     * @Route("/{id}/show", name="squareglobe_show")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanGlobeBundle:Globe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
