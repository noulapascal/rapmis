<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Niveau;
use App\Form\StatOnLevelType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Students;
use App\Entity\Classes;
use App\Entity\Etablissements;
class StatOnLevelController extends AbstractController
{
    /**
     * @Route("/stat/on/level", name="stat_on_level")
     */
    public function index(): Response
    {
        
        return $this->render('stat_on_level/index.html.twig', [
            'controller_name' => 'StatOnLevelController',
        ]); 
    }
    
    /**
     * @Route("/stat/on/levelgen", name="stat_on_level_gen")
     */
    
    public function statGen(Request $request): Response
    {
        $level = new Niveau();
       $form = $this->createForm(StatOnLevelType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
           $niveau = $form->get('niveau')->getData();
           $level = $this->getDoctrine()->getRepository(Niveau::class)->find($niveau);
           $classes = $this->getDoctrine()->getRepository(Classes::class)->findBy([
               'niveau'=>$niveau
           ]);
          
                       
              $students[] = $this->getDoctrine()->getRepository(Students::class)->findBy([
           'classes'=>$classes
                      
                      ]);
          // var_dump($value);
           
 
           $count = count($students);
           dump($count);
           //var_dump($classes);
           //var_dump($students);
       }
        return $this->render('stat_on_level/index.html_1.twig', [
            'controller_name' => 'StatOnLevelController',
            'form'=>$form->createView(),
            'students'=>$students
                
        ]);
    }
}
