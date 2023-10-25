<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Students;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SearchController extends AbstractController {

    /**
     * @Route("/search", name="search")
     */
    public function index( Request $request) {
               $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class)->search($title);
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    /**
     * @Route("/student_admin_search", name="student_admin_search")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function searchSchoolStudent(\Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            $school = $this->getDoctrine()->getManager()->getRepository(\App\Entity\Etablissements::class)->find($this->getUser()->getEtablissements());
            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class)->Adminsearch($title, $school);
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    /**
     * @Route("/student_reg_search/{region?}", name="student_reg_search")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function searchRegStudent(\Symfony\Component\HttpFoundation\Request $request, ?\App\Entity\Regions $region) {
        $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            if(empty($region))
            {
                $region = $this->getDoctrine()->getManager()->getRepository(\App\Entity\Regions::class)->find($this->getUser()->getZone());
            }
            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class)->RegSearch($title, $region);
            
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    /**
     * @Route("/student_dept_search", name="student_dept_search")
     */
    public function searchDeptStudent(\Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            $dept = $this->getDoctrine()->getManager()->getRepository(\App\Entity\Department::class)->find($this->getUser()->getZone());
            // $school= $this->getDoctrine()->getManager()->getRepository(\App\Entity\Etablissements::class)->findBy($city);

            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class);
            $rep->DepSearch($title, $dept);
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    /**
     * @Route("/student_sub_search", name="student_sub_search")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function searchSubStudent(\Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            $sub = $this->getDoctrine()->getManager()->getRepository(\App\Entity\Subdivision::class)->find($this->getUser()->getZone());
            // $school= $this->getDoctrine()->getManager()->getRepository(\App\Entity\Etablissements::class)->findBy($city);

            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class);
            $rep->DeptSearch($title, $dept);
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    
    /**
     * @Route("/search_select", name="search_select")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function searchSelectStudent(\Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(\App\Form\SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->get('title')->getData();
            $sub = $this->getDoctrine()->getManager()->getRepository(\App\Entity\Subdivision::class)->find($this->getUser()->getZone());
            // $school= $this->getDoctrine()->getManager()->getRepository(\App\Entity\Etablissements::class)->findBy($city);

            $rep = $this->getDoctrine()->getManager()->getRepository(Students::class);
            $rep->DeptSearch($title, $dept);
            // var_dump($rep);
            //dump($rep);
        }
        if (empty($rep)) {
            $rep = [];
        }
        return $this->render('search/new.html.twig', [
                    'form' => $form->createView(),
                    'rep' => $rep ? $rep : []
        ]);
    }

    
    
    
}
