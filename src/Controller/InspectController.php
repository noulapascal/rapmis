<?php

namespace App\Controller;

use App\Entity\SectionEduc;
use App\Entity\Type_etablissements;
use App\Repository\EtablissementsRepository;
use App\Entity\Etablissements;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\City;
use App\Entity\Department;
use App\Entity\Country;
use App\Entity\Regions;
use App\Entity\Addresses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;

/**
 * Etablissement controller.
 *
 * @Route("inspect")
 */
class InspectController extends AbstractController
{
    /**
     * Lists all etablissement entities.
     *
     * @Route("/", name="inspect_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_ARR')")
     */
    public function indexInspectAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAllWithCountry();

        return $this->render('inspect/index_ets.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }
    
    /**
     * Lists all etablissement entities.
     *
     * @Route("/", name="del_dep_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_DEPT')")
     */
    public function indexDelDeptAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAllWithCountry();

        return $this->render('inspect/index_ets.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    /**
     * 
     *
     * @Route("/", name="del_reg_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_REGION')")
     */
    public function indexDelRegAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAllWithCountry();

        return $this->render('inspect/index_ets.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    /**
     *
     * @Route("/", name="del_reg_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_PAYS')")
     */
    public function indexMinAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAllWithCountry();

        return $this->render('inspect/index_ets.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }


    

    /**
     * Creates a new etablissement entity.
     *
     * @Route("/new", name="inspect_ets_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etablissement = new Etablissements();
        $form = $this->createForm('App\Form\EtablissementsType', $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etablissement->setCity($form['city']->getData());
            $sigle=$form['sigle']->getData();
            $sigle=strtoupper($sigle);
            $etablissement->setSigle($sigle);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new etablissement secondaire entity.
     *
     * @Route("/news/{who}", name="inspect_ets_news")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")  //@Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newsAction(Request $request, $who)
    {
        $etablissement = new Etablissements();
        $etablissement->setDateCreation(new \DateTime());
        $etablissement->setType_Etablissements($this->getDoctrine()
            ->getRepository('App\Entity\Type_etablissements')
            ->findOneBy(array('name' => $who)));
        $form = $this->createForm('App\Form\EtablissementsType', $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $sigle=$form['sigle']->getData();
            $sigle=strtoupper($sigle);
            $etablissement->setSigle($sigle);

            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a etablissement entity.
     *
     * @Route("/{id}", name="etablissements_show")
     * @Method("GET")
     */
    public function showAction(Etablissements $etablissement)
    {
        $deleteForm = $this->createDeleteForm($etablissement);

        return $this->render('etablissements/show.html.twig', array(
            'etablissement' => $etablissement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing etablissement entity.
     *
     * @Route("/{id}/edit", name="inspect_etablissements_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $etablissement = $this->getDoctrine()->getRepository('App:Etablissements')
            ->findWithCountry($request->get('id'));
        $deleteForm = $this->createDeleteForm($etablissement);
        $editForm = $this->createForm('App\Form\EtablissementsType', $etablissement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/edit.html.twig', array(
            'etablissement' => $etablissement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etablissement entity.
     *
     * @Route("/{id}", name="etablissements_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissements $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('etablissements_index');
    }

    /**
     * Creates a form to delete a etablissement entity.
     *
     * @param Etablissements $etablissement The etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etablissements $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etablissements_delete', array('id' => $etablissement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
