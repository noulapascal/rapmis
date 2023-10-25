<?php

namespace App\Controller;

use App\Entity\Modules;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Enseignants_titulaire;



/**
 * Module controller.
 *
 * @Route("modules")
 */
class ModulesController extends AbstractController
{
    /**
     * Lists all module entities.
     *
     * @Route("/", name="modules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modules = $em->getRepository('App:Modules')->findAll();

        return $this->render('modules/index.html.twig', array(
            'modules' => $modules,
        ));
    }

    /**
     * Creates a new module entity.
     *
     * @Route("/new", name="modules_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request)
    {
        $module = new Modules();
        $form = $this->createForm('App\Form\ModulesType', $module, array(
            'dev' => $this->getUser()->getEtablissements()
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('modules_show', array('id' => $module->getId()));
        }

        return $this->render('modules/new.html.twig', array(
            'module' => $module,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a module entity.
     *
     * @Route("/{id}", name="modules_show")
     * @Method("GET")
     */
    public function showAction(Modules $module)
    {
        $deleteForm = $this->createDeleteForm($module);

        return $this->render('modules/show.html.twig', array(
            'module' => $module,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing module entity.
     *
     * @Route("/{id}/edit", name="modules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Modules $module)
    {
        $deleteForm = $this->createDeleteForm($module);
        $editForm = $this->createForm('App\Form\ModulesType', $module);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modules_show', array('id' => $module->getId()));
        }

        return $this->render('modules/edit.html.twig', array(
            'module' => $module,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a module entity.
     *
     * @Route("/{id}", name="modules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Modules $module)
    {
        $form = $this->createDeleteForm($module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($module);
            $em->flush();
        }

        return $this->redirectToRoute('modules_index');
    }

    /**
     * Creates a form to delete a module entity.
     *
     * @param Modules $module The module entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modules $module)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modules_delete', array('id' => $module->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
