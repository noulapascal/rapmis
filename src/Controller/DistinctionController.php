<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Niveau;
use App\Entity\Distinction;
use App\Form\DistinctionType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EpreuvesType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Epreufe controller.
 *
 * @Route("distinction")
 */

class DistinctionController extends AbstractController
{
    
     /**
     * Lists all epreufe entities.
     *
     * @Route("/", name="distinction_index")
     * @Method("GET")
     */
      public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('App:Distinction')->findAll();

        return $this->render('distinction/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }


    /**
     * Creates a new distinction entity.
     *
     * @Route("/new", name="distinction_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")

     */

    public function newAction(Request $request)
    {
        $teacher=$this->getUser()->getTeacher();
        $epreufe = new Distinction();
        $form = $this->createForm(DistinctionType::class, $epreufe, [
            'ets' =>$this->getUser()->getEtablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em=$this->getDoctrine()->getManager();
            $em->persist($epreufe);
            $em->flush();
           return $this->redirectToRoute('distinction_mail', [ 
               'id'=>$epreufe->getId(),
                'student'=>$form['student']->getData()->getId()
            ]);
            return $this->redirectToRoute('distinction_show', array('id' => $epreufe->getId()));
        }

        return $this->render('distinction/new.html.twig', array(
            'epreufe' => $epreufe,
            'form' => $form->createView(),
        ));
    }
    
        /**
     * Finds and displays a epreufe entity.
     *
     * @Route("/{id}", name="distinction_show")
     * @Method("GET")
     */
    public function showAction(Distinction $epreufe)
    {
        $deleteForm = $this->createDeleteForm($epreufe);

        return $this->render('distinction/show.html.twig', array(
            'epreufe' => $epreufe,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
     /**
     * Deletes a epreufe entity.
     *
     * @Route("/{id}", name="distinction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Epreuves $epreufe)
    {
        $form = $this->createDeleteForm($epreufe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($epreufe);
            $em->flush();
        }

        return $this->redirectToRoute('epreuves_index');
    }
     
      /**
     * Displays a form to edit an existing epreufe entity.
     *
     * @Route("/{id}/edit", name="distinction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Distinction $epreufe)
    {
        $deleteForm = $this->createDeleteForm($epreufe);
        $editForm = $this->createForm(DistinctionType::class, $epreufe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->persist($epreufe);
            $this->getDoctrine()->getManager()->flush();
              return $this->redirectToRoute('distinction_mail', [ 
               'id'=>$epreufe->getId(),
                'student'=>$form['student']->getData()->getId()
            ]);
            return $this->redirectToRoute('epreuves_edit', array('id' => $epreufe->getId()));
        }

        return $this->render('epreuves/edit.html.twig', array(
            'epreufe' => $epreufe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    private function createDeleteForm(Distinction $epreufe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('distinction_delete', array('id' => $epreufe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}