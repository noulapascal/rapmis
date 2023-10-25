<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Medium controller.
 *
 * @Route("media")
 */
class MediaController extends AbstractController
{
    /**
     * Lists all medium entities.
     *
     * @Route("/", name="media_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('App:Media')->findAll();

        return $this->render('media/index.html.twig', array(
            'media' => $media,
        ));
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/new", name="media_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        /*$medium = new Media();
        $form = $this->createForm('App\Form\MediaType', $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medium);
            $em->flush();

            return $this->redirectToRoute('media_show', array('id' => $medium->getId()));
        }

        return $this->render('media/new.html.twig', array(
            'medium' => $medium,
            'form' => $form->createView(),
        ));*/

        $form = $this->createForm('App\Form\UploadType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();

            if($name == 'matieres'){
                return $this->redirectToRoute('matieres_upload');

            }

            if($name == 'addresses'){
                return $this->redirectToRoute('addresses_upload');

            }
            if($name == 'country'){
                return $this->redirectToRoute('country_upload');

            }
            if($name == 'regions'){
                return $this->redirectToRoute('regions_upload');

            }
            if($name == 'department'){
                return $this->redirectToRoute('department_upload');

            }
            if($name == 'city'){
                return $this->redirectToRoute('city_upload');

            }
            if($name == 'système éducatif'){
                return $this->redirectToRoute('syseduc_upload');

            }
            if($name == 'section éducatif'){
                return $this->redirectToRoute('section_upload');

            }
            if($name == 'type d\'établissements'){
                return $this->redirectToRoute('type_etablissements_upload');

            }
            if($name == 'etablissements'){
                return $this->redirectToRoute('etablissements_upload');

            }
            if($name == 'classes'){
                return $this->redirectToRoute('classes_upload');

            }
            if($name == 'staff'){
                return $this->redirectToRoute('staff_upload');

            }
            if($name == 'students'){
                return $this->redirectToRoute('student_upload');

            }
        }

        return $this->render('media/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a medium entity.
     *
     * @Route("/{id}", name="media_show")
     * @Method("GET")
     */
    public function showAction(Media $medium)
    {
        $deleteForm = $this->createDeleteForm($medium);

        return $this->render('media/show.html.twig', array(
            'medium' => $medium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medium entity.
     *
     * @Route("/{id}/edit", name="media_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Media $medium)
    {
        $deleteForm = $this->createDeleteForm($medium);
        $editForm = $this->createForm('App\Form\MediaType', $medium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_edit', array('id' => $medium->getId()));
        }

        return $this->render('media/edit.html.twig', array(
            'medium' => $medium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medium entity.
     *
     * @Route("/{id}", name="media_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Media $medium)
    {
        $form = $this->createDeleteForm($medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medium);
            $em->flush();
        }

        return $this->redirectToRoute('media_index');
    }

    /**
     * Creates a form to delete a medium entity.
     *
     * @param Media $medium The medium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Media $medium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('media_delete', array('id' => $medium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
