<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Students;
use App\Entity\Epreuves;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Service\LocaleSubscriber;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

    /**
     * @Route("/{_locale?fr}", requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|xml",
     *     })
     */

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $etablissements = $em->getRepository('App:Etablissements')->findAll();

            $classes=null;
            if(!empty($this->getUser())){
if($this->getUser()->getEtablissements())
                $students =[];

          //$students = $em->getRepository('App:Students')->findBy([
            //  'etablissement'=>$this->getUser()->getEtablissements()]);
          else
          {
            $students =[];
          }   
      }
      else
      {
        $students =[];
      };
          
//        $classes = $em->getRepository('App:Classes')->findAll();

        //epreuve
      $lien = $em->getRepository('App:LienUtile')->findAll();
        $epreufe = new Epreuves();
        $form = $this->createForm(\App\Form\EpreuvesType::class, $epreufe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file= $form['file']->getData();
            $epreufe->setName("".$this->getUser()->getEtablissements()->getSigle()."_".$this->getUser()->getUsername());
            $epreufe->setFilename("non defini");
            $em->persist($epreufe);
            $em->flush();
            $name = "file_".$epreufe->getId().'.'.$file->guessExtension();
            $directory = __DIR__."/../../public/uploads/epreuves/";
            $epreufe->setFilename($name);
            $file->move($directory, $name);

               $em->persist($epreufe);
            $em->flush();

            return $this->redirectToRoute('epreuves_show', array('id' => $epreufe->getId()));
        }


        //download Epreuve

        $form1 = $this->createForm('App\Form\RechercheEpreuvesType');
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $epreuve = $em->getRepository('App:Epreuves')->findAll();
            return $this->redirectToRoute('epreuves_index',
                array('matieres' => $form1['matieres']->getData(),
                'classes' => $form1['classes']->getData(),
                'name' => $form1['name']->getData(),
                'epreuve' => $epreuve));
        }





        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.project_dir').'/..').DIRECTORY_SEPARATOR,
            'students' => $students,
            'classes' => $classes,
            'etablissements' => $etablissements,
            'epreufe' => $epreufe,
            'lienUtile' => $lien,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            ));
    }



    /**
     * @Route("/event", name="event")
     *
     */
    public function eventAction(Request $request)
    {
        //insert Parent

        $form2 = $this->createForm('App\Form\InsertParentType');
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $parent1 = new Parents();
            $user1 = new User();
            $parent = $em->getRepository('App:Parents')->findOneBy(array('phone'=>$form2['phone']->getData(), 'student_mat'=>$form2['student_mat']->getData()));
            $stud = $em->getRepository('App:Students')->findOneBy(array('name'=>$form2['student_name']->getData(), 'matricule'=>$form2['student_mat']->getData()));
            $user = $em->getRepository('App:User')->findOneBy(array('phoneNumber'=>$form2['phone']->getData()));

            if($parent == null && $stud != null){
                $parent1->setName($form2['name']->getData());
                $parent1->setPhone($form2['phone']->getData());
                $parent1->setEmail($form2['email']->getData());
                $parent1->setStudentName($form2['student_name']->getData());
                $parent1->setStudentMat($form2['student_mat']->getData());
                $em->persist($parent1);
                $em->flush();
                if($user == null){
                    $user1->setUsername($form2['name']->getData());
                    $user1->setPhoneNumber($form2['phone']->getData());
                    $user1->setEmail($form2['email']->getData());
                    $user1->setPlainPassword($form2['phone']->getData());
                    $user1->setRoles(array('ROLE_PARENT'));
                    $em->persist($user1);
                    $em->flush();

                }
            }
            return $this->redirectToRoute('event',
                array('name' => $form2['name']->getData(),
                    'phone' => $form2['phone']->getData(),
                    'email' => $form2['email']->getData(),
                    'student_name' => $form2['student_name']->getData(),
                    'student_mat' => $form2['student_mat']->getData()));
/*            $parent = new User();
            $parent->setUsername($form2['name']);
            $parent->setEmail($form2['name']);
            $parent->setPassword($form2['name']);*/

        }

        return $this->render('default/event.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'form2' => $form2->createView(),
        ));
    }

    /**
     * @Route("/new", name="show_pop")
     */
    public function popupAction(Request $request)
    {
        $request->setLocale('fr');
        return $this->redirectToRoute('homepage');
        // replace this example code with whatever you need
        //return $this->render('default/popup.html.twig');
    }
    /**
     * @Route("/rol", name="roles_switch")
     */
    public function rolAction()
    {
        $this->getUser()->setRoles(['ROLE_ADMIN']);
        $this->getDoctrine()->getManager()->persist($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }


    /**
     * @Route("/testons", name="testons")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function testonsAction()
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('default/testons.html.twig');
        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->render('default/testons1.html.twig');
        }

        return $this->render('default/popup.html.twig');

    }


    /**
     * @Route("/who_is", name="who_is_user")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function who_isAction()
    {

            return $this->render('default/who_is.h  tml.twig');

    }


    /**
     * Generate and save a PDF
     *
     * @Route("/note_repport/{id}/pdf", name="note_repport")
     */
    public function pdfAction($id, Request $request) {
        // get contract from database
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('App:Students')->find($id);

        $path = $request->server->get('DOCUMENT_ROOT');    // C:/wamp64/www/
        $path = rtrim($path, "/");                         // C:/wamp64/www

        $html = $this->renderView('pdf/content.html.twig', array('c' => $c,
            'title' => 'Hello World !',));

        $header = $this->renderView('pdf/header.html.twig', array(
            'path' => $path
        ));
        $footer = $this->renderView('pdf/footer.html.twig', array(
            'customer' => $c->getName()
        ));

        $output = $path . $request->server->get('BASE');        // C:/wamp64/www/project/web
        $output .= '/pdf/bulletin-'. $c->getPrenom() .'.pdf';

        // Generate PDF file
        $this->get('knp_snappy.pdf')->generateFromHtml($html, $output, array(
            'header-html' => $header,
            'footer-html' => $footer,

        ));

        // Message + redirection
        $this->addFlash('success', 'The PDF file has been saved.');
        //return $this->redirectToRoute('students/' .$c->getId());
        return $this->redirect($this->generateUrl('students_show', array('id' => $c->getId())));

    }

//    /**
//     *Generate and save a PDF (note repport)
//     *
//     *@Route("/note_repport/pdf", name="note_repport")
//     */
//    public function pdfAction()
//    {
//        $snappy = $this->get('knp_snappy.pdf');
//
//        $html = $this->renderView('pdf/template.html.twig', array(
//            'title' => 'Hello World !'
//        ));
//
//        $filename = 'myFirstSnappyPDF';
//
//        return new Response(
//            $snappy->getOutputFromHtml($html),
//            200,
//            array(
//                'Content-Type'          => 'application/pdf',
//                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
//            )
//        );
//    }

}
