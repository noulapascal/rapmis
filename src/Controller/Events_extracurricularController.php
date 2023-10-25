<?php

namespace App\Controller;

use App\Entity\Events_extracurricular;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Events_extracurricular controller.
 *
 * @Route("events_extracurricular")
 */
class Events_extracurricularController extends AbstractController
{
    /**
     * Lists all events_extracurricular entities.
     *
     * @Route("/", name="events_extracurricular_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events_extracurriculars = $em->getRepository('App:Events_extracurricular')->findAll();

        return $this->render('events_extracurricular/index.html.twig', array(
            'events_extracurriculars' => $events_extracurriculars,
        ));
    }

    /**
     * Creates a new events_extracurricular entity.
     *
     * @Route("/new", name="events_extracurricular_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $events_extracurricular = new Events_extracurricular();
        $form = $this->createForm('App\Form\Events_extracurricularType', $events_extracurricular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($events_extracurricular);
            $em->flush();

            return $this->redirectToRoute('events_extracurricular_show', array('id' => $events_extracurricular->getId()));
        }

        return $this->render('events_extracurricular/new.html.twig', array(
            'events_extracurricular' => $events_extracurricular,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a events_extracurricular entity.
     *
     * @Route("/{id}", name="events_extracurricular_show")
     * @Method("GET")
     */
    public function showAction(Events_extracurricular $events_extracurricular)
    {
        $deleteForm = $this->createDeleteForm($events_extracurricular);

        return $this->render('events_extracurricular/show.html.twig', array(
            'events_extracurricular' => $events_extracurricular,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing events_extracurricular entity.
     *
     * @Route("/{id}/edit", name="events_extracurricular_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Events_extracurricular $events_extracurricular)
    {
        $deleteForm = $this->createDeleteForm($events_extracurricular);
        $editForm = $this->createForm('App\Form\Events_extracurricularType', $events_extracurricular);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_extracurricular_show', array('id' => $events_extracurricular->getId()));
        }

        return $this->render('events_extracurricular/edit.html.twig', array(
            'events_extracurricular' => $events_extracurricular,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a events_extracurricular entity.
     *
     * @Route("/{id}", name="events_extracurricular_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Events_extracurricular $events_extracurricular)
    {
        $form = $this->createDeleteForm($events_extracurricular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($events_extracurricular);
            $em->flush();
        }

        return $this->redirectToRoute('events_extracurricular_index');
    }

    /**
     * Creates a form to delete a events_extracurricular entity.
     *
     * @param Events_extracurricular $events_extracurricular The events_extracurricular entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Events_extracurricular $events_extracurricular)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_extracurricular_delete', array('id' => $events_extracurricular->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
