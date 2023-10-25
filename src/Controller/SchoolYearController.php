<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Schoolyear controller.
 *
 * @Route("schoolyear")
 */
class SchoolYearController extends AbstractController
{
    /**
     * Lists all schoolYear entities.
     *
     * @Route("/", name="schoolyear_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $schoolYears = $em->getRepository('App:SchoolYear')->findAll();

        return $this->render('schoolyear/index.html.twig', array(
            'schoolYears' => $schoolYears,
        ));
    }

    /**
     * Creates a new schoolYear entity.
     *
     * @Route("/new", name="schoolyear_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $schoolYear = new Schoolyear();
        $form = $this->createForm('App\Form\SchoolYearType', $schoolYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($schoolYear);
            $em->flush();

            return $this->redirectToRoute('schoolyear_show', array('id' => $schoolYear->getId()));
        }

        return $this->render('schoolyear/new.html.twig', array(
            'schoolYear' => $schoolYear,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a schoolYear entity.
     *
     * @Route("/{id}", name="schoolyear_show")
     * @Method("GET")
     */
    public function showAction(SchoolYear $schoolYear)
    {
        $deleteForm = $this->createDeleteForm($schoolYear);

        return $this->render('schoolyear/show.html.twig', array(
            'schoolYear' => $schoolYear,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing schoolYear entity.
     *
     * @Route("/{id}/edit", name="schoolyear_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SchoolYear $schoolYear)
    {
        $deleteForm = $this->createDeleteForm($schoolYear);
        $editForm = $this->createForm('App\Form\SchoolYearType', $schoolYear);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('schoolyear_edit', array('id' => $schoolYear->getId()));
        }

        return $this->render('schoolyear/edit.html.twig', array(
            'schoolYear' => $schoolYear,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a schoolYear entity.
     *
     * @Route("/{id}", name="schoolyear_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SchoolYear $schoolYear)
    {
        $form = $this->createDeleteForm($schoolYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($schoolYear);
            $em->flush();
        }

        return $this->redirectToRoute('schoolyear_index');
    }

    /**
     * Creates a form to delete a schoolYear entity.
     *
     * @param SchoolYear $schoolYear The schoolYear entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SchoolYear $schoolYear)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('schoolyear_delete', array('id' => $schoolYear->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
