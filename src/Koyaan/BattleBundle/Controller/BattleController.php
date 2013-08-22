<?php

namespace Koyaan\BattleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Koyaan\BattleBundle\Entity\Battle;
use Koyaan\BattleBundle\Form\BattleType;

/**
 * Battle controller.
 *
 * @Route("/battle")
 */
class BattleController extends Controller
{
    /**
     * Lists all Battle entities.
     *
     * @Route("/", name="battle")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KoyaanBattleBundle:Battle')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Battle entity.
     *
     * @Route("/{id}/show", name="battle_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBattleBundle:Battle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battle entity.');
        }
        
        $result = $entity->getResults();
        $pixelResult = array(  intval($result[0]),
                                intval($result[1])
                            );
        return array(
            'entity'      => $entity,
            'pixelResult' => $pixelResult
            );
    }

    /**
     * Displays a form to create a new Battle entity.
     *
     * @Route("/new", name="battle_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Battle();
        $form   = $this->createForm(new BattleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Battle entity.
     *
     * @Route("/create", name="battle_create")
     * @Method("post")
     * @Template("KoyaanBattleBundle:Battle:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Battle();
        $request = $this->getRequest();
        $form    = $this->createForm(new BattleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('battle_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Battle entity.
     *
     * @Route("/{id}/edit", name="battle_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBattleBundle:Battle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battle entity.');
        }

        $editForm = $this->createForm(new BattleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Battle entity.
     *
     * @Route("/{id}/update", name="battle_update")
     * @Method("post")
     * @Template("KoyaanBattleBundle:Battle:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBattleBundle:Battle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battle entity.');
        }

        $editForm   = $this->createForm(new BattleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('battle_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Battle entity.
     *
     * @Route("/{id}/delete", name="battle_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KoyaanBattleBundle:Battle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Battle entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('battle'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Casts a vote for a battle entity
     *
     * @Route("/{id}/vote/{vote}", name="battle_vote")
     * @Template()
     */
    public function voteAction($id,$vote)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBattleBundle:Battle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battle entity.');
        }
        if(!in_array($vote, array(1,2))) {
            throw $this->createNotFoundException('Unable to find vote.');
        }
        if($vote == 1)  {
            $entity->setVotes1($entity->getVotes1()+1);
        } else {
            $entity->setVotes2($entity->getVotes2()+1);
        }
        $em->persist($entity);
        $em->flush();
        
//        return $this->redirect($this->generateUrl('battle_show', array('id' => $id)));
        $result = $entity->getResults();
        $pixelResult = array(  intval($result[0]),
                                intval($result[1])
                            );
        return array(
            'entity'      => $entity,
            'pixelResult' => $pixelResult
            );
    }
}
