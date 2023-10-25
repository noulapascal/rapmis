<?php

namespace App\Controller;

use App\Entity\Programme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Form\ProgrammeType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Suggestions;
use App\Entity\Lacunes;
use App\Form\LacunesType;
use App\Form\DevoirType;
use App\Entity\Devoir;
use App\Form\SuggestionsType;

/**
 *Conseil de classe controller
 *
 * @Route("programme")
 */
class ProgrammeController extends AbstractController
{
     /**
     * Lists all epreufe entities.
     *
     * @Route("/", name="programme_index")
     * @Method("GET")
     */
          public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Programme')->findAll();

        return $this->render('programme/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }

   
     /**
     * Lists all epreufe entities.
     *
     * @Route("/suggestions", name="suggestions_index")
     * @Method("GET")
     */
          public function indexSuggestions()
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Suggestions')->findAll();

        return $this->render('lacunes/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }

    
        /**
     * @Route("/suggestions_new" , name="suggestions_new")
     */
    public function newSuggestions(Request $request)
    {
         $suggestion = new Suggestions();
        $form = $this->createForm(SuggestionsType::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                       $em = $this->getDoctrine()->getManager();
                  $tab=$this->getUser()->getTeacher()->getMatieres();
 foreach($tab as $elt=>$val){
                 $suggestion->setMatieres($val);
                $em->persist($val);
            }
       
         $em->persist($suggestion);
            $em->flush();
        }

        return $this->render('lacunes/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    
     /**
     * Lists all epreufe entities.
     *
     * @Route("/suggestions/{id}", name="suggestions_show")
     * @Method("GET")
     */
          public function showSuggestions(Suggestions $lacunes)
    {
        $em = $this->getDoctrine()->getManager();

   //     $cities = $em->getRepository('App:Lacunes')->findAll();

        return $this->render('lacunes/index.html_1.twig', array(
            'epreuves' => $lacunes,
        ));
    }
    
     /**
     * Lists all epreufe entities.
     *
     * @Route("/prog/{id}", name="programme_show")
     * @Method("GET")
     */
          public function showAction(Programme $programme)
    {
        $em = $this->getDoctrine()->getManager();

   //     $cities = $em->getRepository('App:Programme')->findAll();

        return $this->render('programme/index.html_1.twig', array(
            'epreuves' => $programme,
        ));
    }
    
    /**
     * @Route("/new" , name="programme_new")
     */
    
    public function newAction(Request $request)
    {
        $program = new Programme();
        $form = $this->createForm(ProgrammeType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                       $em = $this->getDoctrine()->getManager();

                       if(!empty($form['fichier'])){

                 $file = $form['fichier']->getData();
            $file->move("./uploads/programme", $file->getClientOriginalName());
                       $program->setFilename($file->getClientOriginalName());

                        }
                        if(!empty( $form['chapitres'])){
                         $tab = $form['chapitres']->getData();
            //$tab = $progrm->getChapitres();
            foreach($tab as $elt=>$val){
                $val->setProgramme($program);
                $em->persist($val);
            }
                         if(!empty( $$file)){
               $file = $form['fichier']->getData();
            $file->move("./uploads/programme", $file->getClientOriginalName());
                       $program->setFilename($file->getClientOriginalName());
                       
            $name = 'File_'.$program->getId().".".$file->guessExtension();
            $program->setFilename($name);
            $em->persist($program);
            $em->flush();
                        }
            
                        }
            
          
                        $program->setMatiere($this->getUser()->getTeacher()->getMatieres()[0]);
                        $em->persist($program);
            $em->flush();
            
             if(!empty( $$file)){
               $file = $form['fichier']->getData();
            $file->move("./uploads/programme", $file->getClientOriginalName());
                       $program->setFilename($file->getClientOriginalName());
                       
            $name = 'File_'.$program->getId().".".$file->guessExtension();
            $program->setFilename($name);
            $em->persist($program);
            $em->flush();
                        }

        }

        return $this->render('programme/new.html_1.twig', array(
            'form' => $form->createView(),
        ));
    }
    
   
    
    

    
}
