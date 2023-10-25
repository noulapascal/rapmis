<?php

namespace App\Controller;

use App\Entity\Classes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Form\ClassesType_1;
use App\Entity\Etablissements;
use App\Entity\Media;
use App\Form\ClassesType;
use App\Entity\SchoolYear;


/**
 * Class controller.
 *
 * @Route("classes/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml",
 * })
 */
class ClassesController extends AbstractController
{
    /**
     * Lists all class entities.
     *
     * @Route("/", name="classes_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')") //$this->getUser()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $classes = $em->getRepository('App:Classes')->findBy([
            'etablissements'=>$this->getUser()->getEtablissements()
        ],[
            'schoolYear'=>'desc'
        ]);

        return $this->render('classes/index1.html.twig', array(
            'classes' => $classes,
        ));
    }

    /**
     * @Route("/teacher", name="teacher_classes")
     */
    
    public function teacher_classes() {
        
        return $this->render('classes/index.html.twig',[
            'classes'=>$this->getUser()->getTeacher()->getClasses()
        ]);
    }
    
    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="classes_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadMatieresAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('classes_upload', array('id' => $media->getId()));
        }


        $classes[] = new Classes();
        $media1 =new Media();
        $nom_exel='classes';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'classes'));

        require_once __DIR__.'/../../../vendor/autoload.php';

        if($media1!=null){
            //header('Content-Type: application/msexcel; charset=UTF-8');
            header("Content-Type: text/html; charset=utf-8");
            require_once __DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename();
            $objReader = PHPExcel_IOFactory::createReaderForFile(__DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename());
            $objPHPExcel = $objReader->load(__DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename());
            $objWorksheet = $objPHPExcel->getActiveSheet();
//read on webpagee
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load(__DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename());

            $worksheet = $spreadsheet->getActiveSheet();
            // Get the highest row and column numbers referenced in the worksheet
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5


            echo '<table>' . "\n";
            for ($row = 1; $row <= $highestRow; ++$row) {
                echo '<tr>' . PHP_EOL;
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    echo '<td>' . $value . '</td>' . PHP_EOL;
                }
                echo '</tr>' . PHP_EOL;
            }
            echo '</table>' . PHP_EOL;
//end read



            $i=1;

            foreach ($objWorksheet->getRowIterator() as $row) {
                // $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();//column A
                //you can add your own columns B, C, D etc.

                $classe = new Classes();
                $em1 = $this->getDoctrine()->getManager();

                //etablissements
                $etsGet =  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();
                $ets = $em1->getRepository('App:Etablissements')->findOneBy(array(
                    'name' => $etsGet));
                $classe->setEtablissements($ets);

                //niveau
                $levelGet =  $objPHPExcel->getActiveSheet()->getCell("B$i")->getValue();
                $level = $em1->getRepository('App:Niveau')->findOneBy(array(
                    'name' => $levelGet));
                $classe->setNiveau($level);

                $classe->setName(  $objPHPExcel->getActiveSheet()->getCell("C$i")->getValue() ) ;

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $classes[$i] = $classe;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($classe);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'classes' => $classes,
            'form' => $form->createView(),
        ));

    }


    /**
     * Lists all class entities per school.
     *
     * @Route("/school_classes/{flo}", name="classes_index1")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function index1Action(Etablissements $flo)
    {
        $em = $this->getDoctrine()->getManager();
        
        $date = new \DateTime();
        $mois = intval($date->format('m'));
        if($mois>6){
                    $annee = intval($date->format('Y'));
        }
        else{
            $annee = intval($date->format('Y')) - 1;
        }
        $em = $this->getDoctrine()->getManager();

        $nb = $em->getRepository('App:SchoolYear')->findOneBy([
            'beginningYear'=>$annee
        ]);
        $classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$flo,
            'schoolYear'=>$nb
        ]);





        /*$classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$this->getUser()->getEtablissements(),
        ]);*/

        return $this->render('classes/index.html.twig', array(
            'classes' => $classes,
            'etablissements'=>$flo
        ));
    }
    
    
    
    /**
     * Lists all class entities per school.
     *
     * @Route("/classes_per_year/{flo}", name="classes_per_year")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexSchoolCurrentYearAction(?Etablissements $flo)
    {
        $em = $this->getDoctrine()->getManager();

        $ets= $flo;
        $date = new \DateTime();
        $mois = intval($date->format('m'));
        if($mois>6){
                    $annee = intval($date->format('Y'));
        }
        else{
            $annee = intval($date->format('Y')) - 1;
        }
        $em = $this->getDoctrine()->getManager();

        $nb = $em->getRepository('App:SchoolYear')->findOneBy([
            'beginningYear'=>$annee
        ]);
        $classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$ets,
            'schoolYear'=>$nb
        ]);
        /*$classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$this->getUser()->getEtablissements(),
        ]);*/

        return $this->render('classes/index.html.twig', array(
            'classes' => $classes,
            'etablissements'=>$ets
        ));
    }
    /**
     * Lists all class entities per school.
     *
     * @Route("/classes_with_year/{flo}/{an}", name="classes_year")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexSchoolWithYearAction(?Etablissements $flo,SchoolYear $an)
    {
        $em = $this->getDoctrine()->getManager();

        $ets= $flo;
        $date = new \DateTime();
        $mois = intval($date->format('m'));
        
        $em = $this->getDoctrine()->getManager();


        $classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$ets,
            'schoolYear'=>$an
        ]);
        /*$classes = $em->getRepository('App:Classes')->findby([
            'etablissements'=>$this->getUser()->getEtablissements(),
        ]);*/

        return $this->render('classes/index.html.twig', array(
            'classes' => $classes,
            'etablissements'=>$ets
        ));
    }

    /**
     * Creates a new class entity.
     *
     * @Route("/new", name="classes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $class = new Classes();
        $form = $this->createForm('App\Form\ClassesType', $class,[
            'type'=>$this->getUser()->getEtablissements()->getType_Etablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                        $file = $form->get('emploiDutemps')->getData();
            if (!empty($file)){           
                $class->setFilename($file->getClientOriginalName());     
            }
            $em->persist($class);
            $em->flush();
            $name = "file".$class->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/classes";
            $class->setFilename($name);
            $file->move($directory, $name);
            $em->persist($class);
            $em->flush();
            
                        if(!empty($form['name'])){

                 $file = $form['emploiDuTemps']->getData();
                 $name = "file".$class->getId().'.'.$file->guessExtension();
                 $directory = __DIR__."/../../public/uploads/media/classes";
                 $file->move($directory, $name);
                       $class->setFilename($name);
                        }
                        $em->persist($class);
                        $em->flush();
                        

            return $this->redirectToRoute('classes_show', array('id' => $class->getId()));
        }

        return $this->render('classes/new.html.twig', array(
            'class' => $class,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new class entity base on a particular school.
     *
     * @Route("/new/{dev}", name="classes_newid")
     * @Method({"GET", "POST"})
     */
    public function newidAction(Request $request, $dev)
    {
        $class = new Classes();
        $class->setEtablissements($this->getDoctrine()
            ->getRepository('App\Entity\Etablissements')
            ->findOneBy(array('name' => $dev)));
        /*var_dump($class);
        die();*/
        $form = $this->createForm('App\Form\ClassesType', $class,[
            'type'=>$this->getUser()->getEtablissements()->getType_Etablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                        if(!empty($form['emploiDuTemps'])){
                            
           $file = $form['emploiDuTemps']->getData();
           if(!empty($file))
           {
           
               
           if(!empty($file->getClientOriginalName()))
           {
               
           $file->move("./uploads/media/", $file->getClientOriginalName());
           $class->setFilename($file->getClientOriginalName());
                 
           }       
           
               
           }
           }
            $em->persist($class);
            $classes = $em->getRepository('App:Classes')->findBy(array('etablissements'=>$class->getEtablissements() ,
                'niveau' => $class->getNiveau(),
                'name'=> $class->getName()));
            if($classes){
                // Adding an error type message
                $this->addFlash("warming", "cette classe existe déjà, changé le numéro de la classe");



                return $this->redirectToRoute('classes_newid', array('dev' => $dev));
            };

            $em->flush();
            return $this->redirectToRoute('classes_show', array('id' => $class->getId()));
        }

        return $this->render('classes/new.html.twig', array(
            'class' => $class,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a class entity.
     *
     * @Route("/{id}", name="classes_show")
     * @Method("GET")
     */
    public function showAction(Classes $class)
    {
        $deleteForm = $this->createDeleteForm($class);

        return $this->render('classes/show.html.twig', array(
            'class' => $class,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing class entity.
     *
     * @Route("/{id}/edit", name="classes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Classes $class)
    {
        $deleteForm = $this->createDeleteForm($class);
        $editForm = $this->createForm(ClassesType_1::class, $class,[
            'type'=>$this->getUser()->getEtablissements()->getType_Etablissements()
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $file = $editForm->get('emploiDuTemps')->getData();
            
            if (!empty($file)){           
                $class->setFilename($file->getClientOriginalName());     
            }
            $em->persist($class);
            $em->flush();
            if (!empty($file)){
                            $name = "file".$class->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/classes/";
            $class->setFilename($name);
            $file->move($directory, $name);

                
            }
            $em->persist($class);
            $em->flush();
            
            
            
            return $this->redirectToRoute('classes_show', array('id' => $class->getId()));
        }

        return $this->render('classes/edit.html.twig', array(
            'class' => $class,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a class entity.
     *
     * @Route("/del/{id}", name="classes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Classes $class)
    {
//        $form = $this->createDeleteForm($class);
  //      $form->handleRequest($request);
               /* $form = $this->createDeleteForm($student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
          //  $classe = $student->getClasses()->getId();
            $ets = $class->getEtablissements();
            
            $this->viderClasses($class);
            $em->remove($class);
            $em->flush();
//        }

        return $this->redirectToRoute('classes_index1',[
            'flo'=>$ets->getId()
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($class);
            $em->flush();
        }

        return $this->redirectToRoute('classes_index');
    }

    /**
     * Creates a form to delete a class entity.
     *
     * @param Classes $class The class entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classes $class)
    {
                $directory = __DIR__."/../../public/uploads/media/classes";
        $file = $directory.'/'.$class->getFilename();
         if(is_file($file)){
                    unlink($file);

        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classes_delete', array('id' => $class->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/empty/{id}" ,name ="empty_class")
     * @param Classes $id
     */
    
    
    public function emptyClasses(Classes $id) {
        $classe = $id;
        $em = $this->getDoctrine()->getManager();
        $students = $classe->getStudents();
        foreach ($students as $key => $students) {
            
            $em->remove($students);
        }
        $em->flush();
        return $this->redirectToRoute('students_index_class', [
            'flo'=>$classe->getId(),
            'dev'=>$classe->getNiveau()->getId()
            ]);
        
    }
    
    public function viderClasses(Classes $id) {
        $classe = $id;
        $em = $this->getDoctrine()->getManager();
        $students = $classe->getStudents();
        foreach ($students as $key => $students) {
            
            $em->remove($students);
        }
        $em->flush();
        
    }
    
}
