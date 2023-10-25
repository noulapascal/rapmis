<?php

namespace App\Controller;

use App\Entity\Notes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Note controller.
 *
 * @Route("notes")
 */
class NotesController extends AbstractController
{
    /**
     * Lists all note entities.
     *
     * @Route("/", name="notes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notes = $em->getRepository('App:Notes')->findAll();

        return $this->render('notes/index.html.twig', array(
            'notes' => $notes,
        ));
    }

    /**
     * bulletin
     *
     * @Route("/bulletin", name="bulletin")
     * @Method("GET")
     */
    public function bulletinAction()
    {
       /* $em = $this->getDoctrine()->getManager();

        $notes = $em->getRepository('App:Notes')->findAll();*/

        return $this->render('students/bulletin.html.twig', array(
        ));
    }

    /**
     * Creates a new note entity.
     *
     * @Route("/new", name="notes_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")

     */
    public function newAction(Request $request)
    {
       /* $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('App:Students')->findAll();*/

        $note = new Notes();
        $form = $this->createForm('App\Form\NotesType', $note,[
                        'ets' =>$this->getUser()->getEtablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('notes_show', array('id' => $note->getId()));
        }

        return $this->render('notes/new.html.twig', array(
            'note' => $note,
            /*'students' => $students,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a note entity.
     *
     * @Route("/{id}", name="notes_show")
     * @Method("GET")
     */
    public function showAction(Notes $note)
    {
        $deleteForm = $this->createDeleteForm($note);

        return $this->render('notes/show.html.twig', array(
            'note' => $note,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing note entity.
     *
     * @Route("/{id}/edit", name="notes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notes $note)
    {
        $deleteForm = $this->createDeleteForm($note);
        $editForm = $this->createForm('App\Form\NotesType', $note, [
                        'ets' =>$this->getUser()->getEtablissements()
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notes_edit', array('id' => $note->getId()));
        }

        return $this->render('notes/edit.html.twig', array(
            'note' => $note,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a note entity.
     *
     * @Route("/{id}", name="notes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notes $note)
    {
        $form = $this->createDeleteForm($note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($note);
            $em->flush();
        }

        return $this->redirectToRoute('notes_index');
    }

    /**
     * Creates a form to delete a note entity.
     *
     * @param Notes $note The note entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notes $note)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notes_delete', array('id' => $note->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
