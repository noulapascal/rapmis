<?php

namespace App\Controller;

use App\Entity\LienUtile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Lienutile controller.
 *
 * @Route("lienutile")
 */
class LienUtileController extends AbstractController
{
    /**
     * Lists all lienUtile entities.
     *
     * @Route("/", name="lienutile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lienUtiles = $em->getRepository('App:LienUtile')->findAll();

        return $this->render('lienutile/index.html.twig', array(
            'lienUtiles' => $lienUtiles,
        ));
    }

    /**
     * Creates a new lienUtile entity.
     *
     * @Route("/new", name="lienutile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lienUtile = new Lienutile();
        $form = $this->createForm('App\Form\LienUtileType', $lienUtile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lienUtile);
            $em->flush();

            return $this->redirectToRoute('lienutile_show', array('id' => $lienUtile->getId()));
        }

        return $this->render('lienutile/new.html.twig', array(
            'lienUtile' => $lienUtile,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lienUtile entity.
     *
     * @Route("/{id}", name="lienutile_show")
     * @Method("GET")
     */
    public function showAction(LienUtile $lienUtile)
    {
        $deleteForm = $this->createDeleteForm($lienUtile);

        return $this->render('lienutile/show.html.twig', array(
            'lienUtile' => $lienUtile,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lienUtile entity.
     *
     * @Route("/{id}/edit", name="lienutile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LienUtile $lienUtile)
    {
        $deleteForm = $this->createDeleteForm($lienUtile);
        $editForm = $this->createForm('App\Form\LienUtileType', $lienUtile);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lienutile_edit', array('id' => $lienUtile->getId()));
        }

        return $this->render('lienutile/edit.html.twig', array(
            'lienUtile' => $lienUtile,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lienUtile entity.
     *
     * @Route("/{id}", name="lienutile_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LienUtile $lienUtile)
    {
        $form = $this->createDeleteForm($lienUtile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lienUtile);
            $em->flush();
        }

        return $this->redirectToRoute('lienutile_index');
    }

    /**
     * Creates a form to delete a lienUtile entity.
     *
     * @param LienUtile $lienUtile The lienUtile entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LienUtile $lienUtile)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lienutile_delete', array('id' => $lienUtile->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
