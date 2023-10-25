<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Lacunes;
use App\Form\LacunesType;
use Symfony\Component\HttpFoundation\Request;


/**
 *Lacunes controller
 *
 * @Route("lacunes")
 */
class LacunesController extends AbstractController
{
    
    
      /**
     * Lists all lacunes entities.
     *
     * @Route("/", name="lacunes_index")
     * @Method("GET")
     */
          public function indexLacunes()
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Lacunes')->findAll();

        return $this->render('lacunes/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }

    
    /**
     * @Route("/new" , name="lacunes_new")
     */
    public function newLacunes(Request $request)
    {
        $teacher= $this->getUser()->getTeacher();
         $lacune = new Lacunes();
        $form = $this->createForm(LacunesType::class, $lacune, [
            'ets' =>$this->getUser()->getTeacher()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                       $em = $this->getDoctrine()->getManager();
if(!empty($this->getUser()->getTeacher()))
{
         $mat=$this->getUser()->getTeacher()->getMatieres();
         
         foreach ($mat as $key => $value) {
             if(!empty($value))
          $lacune->setMatieres($value);   
         }
}

          
            $em->persist($lacune);
            $em->flush();
            $this->redirectToRoute('mail_send');

        }

        return $this->render('lacunes/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    
     /**
     * Lists all epreufe entities.
     *
     * @Route("/lacunes/{id}", name="lacunes_show")
     * @Method("GET")
     */
          public function showLacunes(Lacunes $lacunes)
    {
        $em = $this->getDoctrine()->getManager();

   //     $cities = $em->getRepository('App:Lacunes')->findAll();

        return $this->render('lacunes/index.html_1.twig', array(
            'epreuves' => $lacunes,
        ));
    }
}
