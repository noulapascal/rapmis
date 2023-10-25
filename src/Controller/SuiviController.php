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
 * @Route("suivi")
 */
class SuiviController extends AbstractController
{
     /**
     * Lists all epreufe entities.
     *
     * @Route("/", name="homework_index")
     * @Method("GET")
     */
          public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Devoir')->findAll();

        return $this->render('suivi/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }

     /**
     * Lists all epreufe entities.
     *
     * @Route("/lacunes", name="lacunes_index")
     * @Method("GET")
     */
          public function indexLacunes()
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Suggestions')->findAll();

        return $this->render('suivi/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }

    
        /**
     * @Route("/homework_new" , name="homework_new")
     */
    public function newDevoir(Request $request)
    {
         $homework = new Devoir();
        $form = $this->createForm(DevoirType::class, $homework,[
            'teacher'=> $this->getUser()->getTeacher()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                       $em = $this->getDoctrine()->getManager();

           if (!empty($form['chapitres']))
           {
               $tab = $form['chapitres']->getData();
            //$tab = $progrm->getChapitres();
            foreach($tab as $elt=>$val){
                $val->setProgramme($homework);
                $em->persist($val);
            }
            }
          
            $homework->setMatiere($this->getUser()->getTeacher()->getMatieres());
            $em->persist($homework);
            $em->flush();

        }

        return $this->render('suivi/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    
     /**
     * Lists all epreufe entities.
     *
     * @Route("/homework/{id}", name="Devoir_show")
     * @Method("GET")
     */
          public function showDevoir(Lacunes $lacunes)
    {
        $em = $this->getDoctrine()->getManager();

   //     $cities = $em->getRepository('App:Lacunes')->findAll();

        return $this->render('suivi/index.html_1.twig', array(
            'epreuves' => $lacunes,
        ));
    }
    }
    
   
    
    

    

