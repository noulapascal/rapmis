<?php

namespace App\Controller;

use App\Entity\DecisionConseilDeClasse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Form\DecisionConseilDeClasseType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 *Conseil de classe controller
 *
 * @Route("conseil")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class ConseilDeClasseController extends AbstractController
{
     /**
     * Lists all epreufe entities.
     *
     * @Route("/", name="conseil_index")
     * @Method("GET")
     */
          public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('App:DecisionConseilDeClasse')->findAll();

        return $this->render('conseil/index.html.twig', array(
            'epreuves' => $cities,
        ));
    }
    
    /**
     * @Route("/new" , name="conseil_new")
     */
    public function newAction(Request $request)
    {
        $teacher = $this->getUser()->getTeacher();
        $conseil = new DecisionConseilDeClasse();
        $form = $this->createForm(DecisionConseilDeClasseType::class, $conseil, [
    'ets' =>$teacher ?$this->getUser()->getTeacher()->getEtablissements():$this->getUser()->getEtablissements()]
);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('bulletin')->getData();
               if(!empty($form['bulletin'])){

                 $file = $form['bulletin']->getData();
                 $fileName = "Bulletin".$form->get('student')->getData()->getId().'.'.$file->guessExtension();
            $file->move("./uploads/bulletin",$fileName );
                       $conseil->setBulletin($fileName);

                        }

            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush();
                       return $this->redirectToRoute('mail_send', [
                'name'=>'conseil de classe',
                'student'=>$form['student']->getData()->getId()
            ]);

            return $this->redirectToRoute('conseil_index');
        }

        return $this->render('conseil/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
}
