<?php

namespace App\Controller;

use App\Entity\RegSel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Regsel controller.
 *
 * @Route("regsel")
 */
class RegSelController extends AbstractController
{
    /**
     * Lists all regSel entities.
     *
     * @Route("/", name="regsel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regSels = $em->getRepository('App:RegSel')->findAll();

        return $this->render('regsel/index.html.twig', array(
            'regSels' => $regSels,
        ));
    }

    /**
     * Creates a new regSel entity.
     *
     * @Route("/new", name="regsel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $regSel = new Regsel();
        $form = $this->createForm('App\Form\RegSelType', $regSel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($regSel);
            $em->flush();

            return $this->redirectToRoute('regsel_show', array('id' => $regSel->getId()));
        }

        return $this->render('regsel/new.html.twig', array(
            'regSel' => $regSel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a regSel entity.
     *
     * @Route("/{id}", name="regsel_show")
     * @Method("GET")
     */
    public function showAction(RegSel $regSel)
    {
        $deleteForm = $this->createDeleteForm($regSel);

        return $this->render('regsel/show.html.twig', array(
            'regSel' => $regSel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing regSel entity.
     *
     * @Route("/{id}/edit", name="regsel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegSel $regSel)
    {
        $deleteForm = $this->createDeleteForm($regSel);
        $editForm = $this->createForm('App\Form\RegSelType', $regSel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('regsel_edit', array('id' => $regSel->getId()));
        }

        return $this->render('regsel/edit.html.twig', array(
            'regSel' => $regSel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a regSel entity.
     *
     * @Route("/{id}", name="regsel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RegSel $regSel)
    {
        $form = $this->createDeleteForm($regSel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($regSel);
            $em->flush();
        }

        return $this->redirectToRoute('regsel_index');
    }

    /**
     * Creates a form to delete a regSel entity.
     *
     * @param RegSel $regSel The regSel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegSel $regSel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regsel_delete', array('id' => $regSel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
