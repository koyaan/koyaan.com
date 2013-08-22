<?php

namespace Koyaan\BsBotBundle\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Koyaan\BsBotBundle\BotBundle\Entity\Buzzword;
use Koyaan\BsBotBundle\BotBundle\Form\BuzzwordType;

/**
 * Buzzword controller.
 *
 * @Route("/buzzword")
 */
class BuzzwordController extends Controller
{
    /**
     * Lists all Buzzword entities.
     *
     * @Route("/", name="buzzword")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KoyaanBsBotBundleBotBundle:Buzzword')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Buzzword entity.
     *
     * @Route("/{id}/show", name="buzzword_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBsBotBundleBotBundle:Buzzword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buzzword entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Buzzword entity.
     *
     * @Route("/new", name="buzzword_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Buzzword();
        $form   = $this->createForm(new BuzzwordType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Buzzword entity.
     *
     * @Route("/create", name="buzzword_create")
     * @Method("post")
     * @Template("KoyaanBsBotBundleBotBundle:Buzzword:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Buzzword();
        $request = $this->getRequest();
        $form    = $this->createForm(new BuzzwordType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('buzzword_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Buzzword entity.
     *
     * @Route("/{id}/edit", name="buzzword_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBsBotBundleBotBundle:Buzzword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buzzword entity.');
        }

        $editForm = $this->createForm(new BuzzwordType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Buzzword entity.
     *
     * @Route("/{id}/update", name="buzzword_update")
     * @Method("post")
     * @Template("KoyaanBsBotBundleBotBundle:Buzzword:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KoyaanBsBotBundleBotBundle:Buzzword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buzzword entity.');
        }

        $editForm   = $this->createForm(new BuzzwordType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('buzzword_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Buzzword entity.
     *
     * @Route("/{id}/delete", name="buzzword_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KoyaanBsBotBundleBotBundle:Buzzword')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Buzzword entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('buzzword'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
