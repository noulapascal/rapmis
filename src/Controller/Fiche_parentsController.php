<?php

namespace App\Controller;

use App\Entity\Fiche_parents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fiche_parent controller.
 *
 * @Route("fiche_parents")
 */
class Fiche_parentsController extends AbstractController
{
    /**
     * Lists all fiche_parent entities.
     *
     * @Route("/", name="fiche_parents_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fiche_parents = $em->getRepository('App:Fiche_parents')->findAll();

        return $this->render('fiche_parents/index.html.twig', array(
            'fiche_parents' => $fiche_parents,
        ));
    }

    /**
     * Creates a new fiche_parent entity.
     *
     * @Route("/new", name="fiche_parents_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fiche_parent = new Fiche_parents();
        $form = $this->createForm('App\Form\Fiche_parentsType', $fiche_parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fiche_parent);
            $em->flush();

            return $this->redirectToRoute('fiche_parents_show', array('id' => $fiche_parent->getId()));
        }

        return $this->render('fiche_parents/new.html.twig', array(
            'fiche_parent' => $fiche_parent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fiche_parent entity.
     *
     * @Route("/{id}", name="fiche_parents_show")
     * @Method("GET")
     */
    public function showAction(Fiche_parents $fiche_parent)
    {
        $deleteForm = $this->createDeleteForm($fiche_parent);

        return $this->render('fiche_parents/show.html.twig', array(
            'fiche_parent' => $fiche_parent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fiche_parent entity.
     *
     * @Route("/{id}/edit", name="fiche_parents_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fiche_parents $fiche_parent)
    {
        $deleteForm = $this->createDeleteForm($fiche_parent);
        $editForm = $this->createForm('App\Form\Fiche_parentsType', $fiche_parent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiche_parents_show', array('id' => $fiche_parent->getId()));
        }

        return $this->render('fiche_parents/edit.html.twig', array(
            'fiche_parent' => $fiche_parent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fiche_parent entity.
     *
     * @Route("/{id}", name="fiche_parents_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fiche_parents $fiche_parent)
    {
        $form = $this->createDeleteForm($fiche_parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fiche_parent);
            $em->flush();
        }

        return $this->redirectToRoute('fiche_parents_index');
    }

    /**
     * Creates a form to delete a fiche_parent entity.
     *
     * @param Fiche_parents $fiche_parent The fiche_parent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fiche_parents $fiche_parent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fiche_parents_delete', array('id' => $fiche_parent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
