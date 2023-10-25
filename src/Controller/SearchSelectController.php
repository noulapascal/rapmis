<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchRegSelectType;
use App\Form\SearchDeptSelectType;
use App\Form\SearchSubSelectType;
use App\Form\SearchCountrySelectType;
class SearchSelectController extends AbstractController
{
    /**
     * @Route("/search/select", name="search_select")
     */
    public function index(): Response
    {
        return $this->render('search_select/index.html.twig', [
            'controller_name' => 'SearchSelectController',
        ]);
    }
    
    
    
    /**
     * @Route("/search/select", name="search_select")
     * 
     */
    
    public function searchSelectCountry(Request $request) {
        $form = $this->createForm(SearchCountrySelectType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        $country = $form->get('country')->getData();
            
        return $this->redirectToRoute('search_select_region', [
            'country'=>$country->getId()
        ]);
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
     * @Route("/search/select_for_dept", name="search_select_for_dept")
     * 
     */
    
    public function searchSelectCountryForDept(Request $request) {
        $form = $this->createForm(SearchCountrySelectType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        $country = $form->get('country')->getData();
            
        return $this->redirectToRoute('search_select_dept', [
            'country'=>$country->getId()
        ]);
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
     * @Route("/search/select_for_sub", name="search_select_for_sub")
     * 
     */
    
    public function searchSelectForSub(Request $request) {
        $form = $this->createForm(SearchCountrySelectType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        $country = $form->get('country')->getData();
            
        return $this->redirectToRoute('search_select_sub', [
            'country'=>$country->getId()
        ]);
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
     * @Route("/search/select_region/{country}", name="search_select_region")
     * 
     */
    public function searchSelectReg(\App\Entity\Country $country, Request $request)
    {
       //   $form = $this->createForm(SearchRegSelectType::class,null,['country'=>$this->getDoctrine()->getRepository(\App\Entity\Country::class)->find($country)]
         //         );
        //  $form2 = $this->createForm(SearchDeptSelectType::class,null  );
          $form3 = $this->createForm(\App\Form\SearchRegSelectType::class,null,[
              'country'=>$country
          ] );
        $form3->handleRequest($request);
        if($form3->isSubmitted() && $form3->isValid())
        {
            
            $region = $form3->get('region')->getData();
             return $this->redirectToRoute('student_reg_search', [
            'region'=>$region->getId()
        ]);
        }
                    if (empty($rep)) {
            $rep = [];
        }
            return $this->render('search_select/new.html.twig', [
           // 'form' => $form->createView(),
            //'form2' => $form2->createView(),
            'form' => $form3->createView(),
                'rep' => $rep ? $rep : []

        ]);
    }
    
    
    /**
     * @Route("/search/select_dept/{country}", name="search_select_dept")
     * 
     */
    public function searchSelectDept(\App\Entity\Country $country, Request $request)
    {
       //   $form = $this->createForm(SearchRegSelectType::class,null,['country'=>$this->getDoctrine()->getRepository(\App\Entity\Country::class)->find($country)]
         //         );
        //  $form2 = $this->createForm(SearchDeptSelectType::class,null  );
        $regions=$country->getRegions();
        $dept= [];
        foreach ($regions as $value) {
            $dept[]= $value->getDepartments();
        }
        foreach ($dept as $key => $value) {
            foreach ($value as $val){
                $dep[]= $val;
            }
        }
          $form3 = $this->createForm(\App\Form\SearchDeptSelectType::class,null,[
              'country'=>!empty($dep)?$dep:[]
          ]  );
        $form3->handleRequest($request);
        if($form3->isSubmitted() && $form3->isValid())
        {
             $region = $form3->get('departments')->getData();
             return $this->redirectToRoute('student_dept_search', [
            'region'=>$region->getId()
        ]);
        }
                    if (empty($rep)) {
            $rep = [];
        }
            return $this->render('search_select/new.html.twig', [
           // 'form' => $form->createView(),
            //'form2' => $form2->createView(),
            'form' => $form3->createView(),
                'rep' => $rep ? $rep : []

        ]);
    }
    
    
    
    
    /**
     * @Route("/search/select_sub/{country}", name="search_select_sub")
     * 
     */
    public function searchSelectSub(\App\Entity\Country $country, Request $request)
    {
       //   $form = $this->createForm(SearchRegSelectType::class,null,['country'=>$this->getDoctrine()->getRepository(\App\Entity\Country::class)->find($country)]
         //         );
        //  $form2 = $this->createForm(SearchDeptSelectType::class,null  );
          $form3 = $this->createForm(\App\Form\SearchSubSelectType_1::class,null  );
        $form3->handleRequest($request);
        if($form3->isSubmitted() && $form3->isValid())
        {
            
        }
                    if (empty($rep)) {
            $rep = [];
        }
            return $this->render('search_select/new.html.twig', [
           // 'form' => $form->createView(),
            //'form2' => $form2->createView(),
            'form' => $form3->createView(),
                'rep' => $rep ? $rep : []

        ]);
    }
    
    
}
