<?php

namespace App\Controller;

use App\Entity\Enseignants_titulaire;
use App\Form\Enseignants_titulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\Enseignants_titulaireRepository;


/**
 * Enseignants_titulaire controller.
 *
 * @Route("enseignants_titulaire")
 */
class Enseignants_titulaireController extends AbstractController
{
    /**
     * Lists all enseignants_titulaire entities.
     *
     * @Route("/", name="enseignants_titulaire_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$enseignants_titulaires = $em->getRepository('App:Enseignants_titulaire')->findAll();


        $teacher = $em->getRepository('App:Teacher')
            ->findBy(array('etablissements'=>$this->getUser()->getEtablissements()));

        $enseignants_titulaires = $em->getRepository('App:Enseignants_titulaire')
            ->createQueryBuilder('c')
            ->where('c.teacher IN (:teacher)')
            ->setParameter('teacher', $teacher)
        //dump($qb);
        ->getQuery()->getResult();

        return $this->render('enseignants_titulaire/index.html.twig', array(
            'enseignants_titulaires' => $enseignants_titulaires,
        ));
    }

    /**
     * Creates a new enseignants_titulaire entity.
     *
     * @Route("/new", name="enseignants_titulaire_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request)
    {
        $enseignants_titulaire = new Enseignants_titulaire();
        //$form = $this->createForm('App\Form\Enseignants_titulaireType', $enseignants_titulaire);
        $form = $this->createForm(Enseignants_titulaireType::class, $enseignants_titulaire,  [
            'dev' => $this->getUser()->getEtablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignants_titulaire);
            $em->flush();

            return $this->redirectToRoute('enseignants_titulaire_show', array('id' => $enseignants_titulaire->getId()));
        }

        return $this->render('enseignants_titulaire/new.html.twig', array(
            'enseignants_titulaire' => $enseignants_titulaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enseignants_titulaire entity.
     *
     * @Route("/{id}", name="enseignants_titulaire_show")
     * @Method("GET")
     */
    public function showAction(Enseignants_titulaire $enseignants_titulaire)
    {
        $deleteForm = $this->createDeleteForm($enseignants_titulaire);

        return $this->render('enseignants_titulaire/show.html.twig', array(
            'enseignants_titulaire' => $enseignants_titulaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enseignants_titulaire entity.
     *
     * @Route("/{id}/edit", name="enseignants_titulaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Enseignants_titulaire $enseignants_titulaire)
    {
        $deleteForm = $this->createDeleteForm($enseignants_titulaire);
        $editForm = $this->createForm('App\Form\Enseignants_titulaireType', $enseignants_titulaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignants_titulaire_show', array('id' => $enseignants_titulaire->getId()));
        }

        return $this->render('enseignants_titulaire/edit.html.twig', array(
            'enseignants_titulaire' => $enseignants_titulaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enseignants_titulaire entity.
     *
     * @Route("/{id}", name="enseignants_titulaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Enseignants_titulaire $enseignants_titulaire)
    {
        $form = $this->createDeleteForm($enseignants_titulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enseignants_titulaire);
            $em->flush();
        }

        return $this->redirectToRoute('enseignants_titulaire_index');
    }

    /**
     * Creates a form to delete a enseignants_titulaire entity.
     *
     * @param Enseignants_titulaire $enseignants_titulaire The enseignants_titulaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Enseignants_titulaire $enseignants_titulaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enseignants_titulaire_delete', array('id' => $enseignants_titulaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
