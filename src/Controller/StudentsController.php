<?php

namespace App\Controller;

use App\Entity\Etablissements;
use App\Entity\Media;
use App\Entity\Niveau;
use App\Entity\Students;
use App\Entity\Notes;
use App\Entity\User;
use App\Form\StudentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use PHPExcel_IOFactory;
use App\Entity\Classes;
use App\Form\MediaType;


/**
 * Student controller.
 *
 * @Route("students/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml"}
 * )
 */
class StudentsController extends AbstractController
{
    /**
     * Lists all student entities.
     *
     * @Route("/", name="students_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$students = $em->getRepository('App:Students')->findAll();

        $classes = $em->getRepository('App:Classes')
            ->findBy(array('etablissements'=>$this->getUser()->getEtablissements()));

        $students = $em->getRepository('App:Students')
            ->createQueryBuilder('c')
            ->where('c.classes IN (:classes)')
            ->setParameter('classes', $classes)
            //dump($qb);
            ->getQuery()->getResult();



        // pour les notes
        $em1 = $this->getDoctrine()->getManager();

        $notes = $em1->getRepository('App:Notes')->findAll();



        return $this->render('students/index.html.twig', array(
            'students' => $students,
            'notes' => $notes,
        ));

    }
    /**
     * Lists all student entities.
     *
     * @Route("/list", name="students_list")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$students = $em->getRepository('App:Students')->findAll();

        $students = $em->getRepository('App:Students')
            ->findBy(array('telResponsable'=>$this->getUser()->getUsername()));

        return $this->render('students/index.html.twig', array(
            'students' => $students,
        ));

    }

    /**
     * Lists all student entities.
     *
     * @Route("/All", name="students_admin_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function indexAdmin()
    {
        $em = $this->getDoctrine()->getManager();
        //$students = $em->getRepository('App:Students')->findAll();

        $etablissements = $em->getRepository('App:Etablissements')
            ->findAll();

  /*      $students = $em->getRepository('App:Students')
            ->createQueryBuilder('c')
            ->where('c.classes IN (:classes)')
            ->setParameter('classes', $classes)
            //dump($qb);
            ->getQuery()->getResult();



        // pour les notes
        $em1 = $this->getDoctrine()->getManager();

        $notes = $em1->getRepository('App:Notes')->findAll();

*/
        if($this->isGranted('ROLE_SUPER_ADMIN'))
        {
            $an = $em->getRepository('App:SchoolYear')->findAll();

        return $this->render('admin/index.html_1.twig', array(
            'etablissements' => $etablissements,
            'schoolYear' => $an,
        ));
        }
        else{
            
        return $this->render('viewer/index.html_1.twig', array(
            'etablissements' => $etablissements,
          //  'notes' => $notes,
        ));
        }

    }

    
    
    
    
    
    /**
     * Lists all student entities per class.  var_dump
     *
     * @Route("/class/{flo}/{dev}", name="students_index_class")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function index_classAction(Classes $flo, $dev)
    {
        $em = $this->getDoctrine()->getManager();

            
            $classe = $flo;
        $students = $em->getRepository('App:Students')->findBy(['classes'=>$classe]);

        //$students = $em->getRepository('App:Students')->findBy (
         //   array( 'classes.name' => $flo, 'classes.niveau.name' => $dev));

        //$students = $em->getRepository('App:Students')->findByStudents($dev, $flo);



        return $this->render('students/index_class.html.twig', array(
            'students' => $students,
            'flo' => $flo,
            'dev' => $dev
        ));
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="student_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadStudentAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /**
             * File $file
             */
            $file = $form->get('file')->getData();
            if (!empty($file)){           
                $media->setFilename($file->getClientOriginalName());     
            }
            $em->persist($media);
            $em->flush();
            if(!empty($file->guessExtension()))
            {
                $name = "file".$media->getId().'.'.$file->guessExtension();
            }
            else
            {
                $name = "file".$media->getId().'.'.'txt';
            }
             $directory = __DIR__."/../../public/uploads/media/";
            $media->setFilename($name);
            $file->move($directory, $name);
            $em->persist($media);
            $em->flush();
            dump($name);
            $mime=mime_content_type( __DIR__.'/../../public/uploads/media/'.''.$media->getFilename());
            if(stripos($media->getFilename(), '.csv') or stripos($media->getFilename(), '.txt') ){
            	return $this->redirectToRoute('mediaStudent', array('id' => $media->getId()));
	
        }else
        
        {
        	return $this->redirectToRoute('', array('id' => $media->getId()));

        }
            
        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'form' => $form->createView(),
        ));

    }
	

	/**
     * Creates a new medium entity.
     *
     * @Route("/upload_excel/{id}", name="student_upload_excel")|
     * @Method({"GET", "POST"})
     */


	public function upload_excel(Media $id)
	{


        $students[] = new students();
        $media1 = $id;
        $nom_exel='students';
        $em = $this->getDoctrine()->getManager();
        require_once __DIR__.'/../../../vendor/autoload.php';

        if($media1->getFilename()){

         // header('Content-Type: application/msexcel; charset=UTF-8');
           // header("Content-Type: text/html; charset=utf-8");
            require_once __DIR__.'/../../public/uploads/media/'.''.$media1->getFilename();
            $objReader = PHPExcel_IOFactory::createReaderForFile(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename());
            $objPHPExcel = $objReader->load(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename());
            $objWorksheet = $objPHPExcel->getActiveSheet();
//read on webpagee
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename());

            $worksheet = $spreadsheet->getActiveSheet();
            // Get the highest row and column numbers referenced in the worksheet
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5


/*            echo '<table>' . "\n";
            for ($row = 1; $row <= $highestRow; ++$row) {
                echo '<tr>' . PHP_EOL;
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                    echo '<td>' . $value . '</td>' . PHP_EOL;
                }
                echo '</tr>' . PHP_EOL;
            }
            echo '</table>' . PHP_EOL;*/
//end read



            $i=6;

            foreach ($objWorksheet->getRowIterator() as $row) {
                // $column_A_Value = $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();//column A
                //you can add your own columns B, C, D etc.

                $student = new Students();

                $em1 = $this->getDoctrine()->getManager();
                $em2 = $this->getDoctrine()->getManager();
                $em3 = $this->getDoctrine()->getManager();
                //etablissement
                $ets =  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();
                                $etablissementGet = strtoupper($ets);
                $etablissement = $em1->getRepository('App:Etablissements')->findOneBy(array(
                    'sigle' => $etablissementGet));

                //niveau
                $niveauGet =  $objPHPExcel->getActiveSheet()->getCell("B$i")->getValue();
                $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                    'name' => $niveauGet));
                if(empty($niveau)){
                     $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                    'name' => strtoupper($niveauGet)));
                     if(empty($niveau)){
                          $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                    'name' => strtolower($niveauGet)));
                     }
                }

                //classes
                $classeGet =  $objPHPExcel->getActiveSheet()->getCell("C$i")->getValue();
                $classes = $em3->getRepository('App:Classes')->findOneBy(array(
                    'name' => $classeGet, 'etablissements' => $etablissement, 'niveau' => $niveau));
                if(empty($classes)){
                $classes = $em3->getRepository('App:Classes')->findOneBy(array(
                    'name' => strtolower($classeGet), 'etablissements' => $etablissement, 'niveau' => $niveau));    
                if(empty($classes)){
                    $classes = $em3->getRepository('App:Classes')->findOneBy(array(
                    'name' => strtoupper($classeGet), 'etablissements' => $etablissement, 'niveau' => $niveau));
                
                }
                
                }
                $student->setClasses($classes);
                $student->setName($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue() ) ;
                if(!empty($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue()))
                {
                	                $student->setFirstName($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue() ) ;

                }
                else{
                	                $student->setFirstName('non definie') ;

                }
                $student->setPere($objPHPExcel->getActiveSheet()->getCell("F$i")->getValue() ) ;
                $student->setMere($objPHPExcel->getActiveSheet()->getCell("G$i")->getValue() ) ;
                $student->setTuteur($objPHPExcel->getActiveSheet()->getCell("H$i")->getValue() ) ;
                $student->setTelPere($objPHPExcel->getActiveSheet()->getCell("I$i")->getValue() ) ;
                $student->setTelMere($objPHPExcel->getActiveSheet()->getCell("J$i")->getValue() ) ;
                $student->setTelTuteur($objPHPExcel->getActiveSheet()->getCell("K$i")->getValue() ) ;
                $student->setEmailPere($objPHPExcel->getActiveSheet()->getCell("L$i")->getValue() ) ;
                $student->setEmailMere($objPHPExcel->getActiveSheet()->getCell("M$i")->getValue() ) ;
                $student->setEmailTuteur($objPHPExcel->getActiveSheet()->getCell("N$i")->getValue()) ;
                $student->setProfPere($objPHPExcel->getActiveSheet()->getCell("O$i")->getValue() ) ;
                $student->setProfMere($objPHPExcel->getActiveSheet()->getCell("P$i")->getValue() ) ;
                $student->setProfTuteur($objPHPExcel->getActiveSheet()->getCell("Q$i")->getValue() ) ;
                $student->setResidenceParents($objPHPExcel->getActiveSheet()->getCell("R$i")->getValue() ) ;
                $student->setProche1($objPHPExcel->getActiveSheet()->getCell("S$i")->getValue() ) ;
                $student->setTelProche1($objPHPExcel->getActiveSheet()->getCell("T$i")->getValue() ) ;
                $student->setProche2($objPHPExcel->getActiveSheet()->getCell("U$i")->getValue() ) ;
                $student->setTelProche2($objPHPExcel->getActiveSheet()->getCell("V$i")->getValue() ) ;
                $student->setProche3($objPHPExcel->getActiveSheet()->getCell("W$i")->getValue() ) ;
                $student->setTelProche3($objPHPExcel->getActiveSheet()->getCell("X$i")->getValue() ) ;
                if(!empty($objPHPExcel->getActiveSheet()->getCell("Y$i")->getValue()) ) 
{
                $student->setNouveau($objPHPExcel->getActiveSheet()->getCell("Y$i")->getValue() ) ;

                }
                else
                {
                	                $student->setNouveau('non defini') ;

                }

                 if(!empty($objPHPExcel->getActiveSheet()->getCell("Z$i")->getValue())  ) 
{
                $student->setRedoublant($objPHPExcel->getActiveSheet()->getCell("Z$i")->getValue() ) ;

                }
                else
                {
                	                $student->setRedoublant('non defini') ;

                }
           //     $student->setRedoublant($objPHPExcel->getActiveSheet()->getCell("Z$i")->getValue() ) ;
                                 if(!empty($objPHPExcel->getActiveSheet()->getCell("AA$i")->getValue())  ) 
{
                $student->setEtudeDossier($objPHPExcel->getActiveSheet()->getCell("AA$i")->getValue() ) ;

                }
                else
                {
                	                $student->setEtudeDossier('non defini') ;

                }


             //   $student->setEtudeDossier($objPHPExcel->getActiveSheet()->getCell("AA$i")->getValue() ) ;


                $excel_date = $objPHPExcel->getActiveSheet()->getCell("AB$i")->getValue(); //here is that value 41621 or 41631
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = 25569 + ($unix_date / 86400);
                $unix_date = ($excel_date - 25569) * 86400;
                // echo gmdate("Y-m-d", $unix_date);
                $newDate = date('Y-m-d', $unix_date);
                // var_dump(gmdate("Y-m-d", $unix_date));

                if (\PHPExcel_Shared_Date::isDateTime($objPHPExcel->getActiveSheet()->getCell("AB$i"))) {
                    $dateTimeObject = \PHPExcel_Shared_Date::ExcelToPHPObject($excel_date);
                   // var_dump($dateTimeObject->format('Y-M-d'));
                    // echo $dateTimeObject->format('Y-M-d'), PHP_EOL;
                    $student->setAnneeNais(new \datetime($dateTimeObject->format('Y-M-d'))) ;

                }

                $student->setLieuDeNaissance($objPHPExcel->getActiveSheet()->getCell("AC$i")->getFormattedValue() ) ;
                $student->setSexe($objPHPExcel->getActiveSheet()->getCell("AD$i")->getFormattedValue() ) ;
                $student->setCycle($objPHPExcel->getActiveSheet()->getCell("AE$i")->getFormattedValue() ) ;
                $student->setResponsable($objPHPExcel->getActiveSheet()->getCell("AF$i")->getFormattedValue() ) ;
                $student->setTelResponsable($objPHPExcel->getActiveSheet()->getCell("AG$i")->getValue() ) ;
                $student->setEmailResponsable($objPHPExcel->getActiveSheet()->getCell("AH$i")->getValue() ) ;
                $student->setSerie($objPHPExcel->getActiveSheet()->getCell("AI$i")->getValue() ) ;
                $student->setMoyPassageClasse($objPHPExcel->getActiveSheet()->getCell("AJ$i")->getValue() ) ;
                $student->setRang($objPHPExcel->getActiveSheet()->getCell("AK$i")->getValue() ) ;
                $student->setLastSchool($objPHPExcel->getActiveSheet()->getCell("AL$i")->getFormattedValue() ) ;
                $student->setNameChefLastSchool($objPHPExcel->getActiveSheet()->getCell("AM$i")->getFormattedValue() ) ;
                $student->setGroupeSanguin($objPHPExcel->getActiveSheet()->getCell("AN$i")->getValue() ) ;
                $student->setPathogieParticuliere($objPHPExcel->getActiveSheet()->getCell("AO$i")->getValue() ) ;
                $student->setAllergieAlimentaire($objPHPExcel->getActiveSheet()->getCell("AP$i")->getValue() ) ;
                $student->setAllergieMedicamenteuse($objPHPExcel->getActiveSheet()->getCell("AQ$i")->getValue() ) ;
                $student->setDispense($objPHPExcel->getActiveSheet()->getCell("AR$i")->getFormattedValue() ) ;
                $student->setMedecinFamiliale($objPHPExcel->getActiveSheet()->getCell("AS$i")->getFormattedValue() ) ;
                $student->setTelMedecinFamiliale($objPHPExcel->getActiveSheet()->getCell("AT$i")->getValue() ) ;
                $student->setAssuranceFamille($objPHPExcel->getActiveSheet()->getCell("AU$i")->getValue() ) ;
                $student->setHopitalAgree($objPHPExcel->getActiveSheet()->getCell("AV$i")->getValue() ) ;
                $student->setRhesus($objPHPExcel->getActiveSheet()->getCell("AW$i")->getValue() ) ;
                $student->setInaptitude($objPHPExcel->getActiveSheet()->getCell("AX$i")->getValue() ) ;
                $student->setFilename($objPHPExcel->getActiveSheet()->getCell("AY$i")->getValue() ) ;
                $student->setMatricule($objPHPExcel->getActiveSheet()->getCell("AZ$i")->getValue() ) ;


                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityMan = $this->getDoctrine()->getManager();                
                $user = $entityMan->getRepository('App:User')->findOneBy(array('phoneNumber'=>$student->getTelResponsable()));

                if($user == null && !empty($student->getTelResponsable())){
                    $user1=new User();
                    $user1->setUsername($student->getTelResponsable());
                    $user1->setPhoneNumber($student->getTelResponsable());
  //                  if(empty($student->getEmailResponsable()))
    //                {
      //              $user1->setEmail($student->getEmailResponsable());	
        //            } else{
              //      	$user1->setEmail($student->getTelResponsable()."@rapmis.com");
          //          }
                    $user1->setPassword($passwordEncoder->encodePassword(
                    $user,$student->getTelResponsable()));
                
                  //  $user1->setPlainPassword($student->getTelResponsable());
                    $user1->setRoles(array('ROLE_PARENT'));
                    $user1->setEnabled("1");

                                        
                }

                $entityManager = $this->getDoctrine()->getManager();

                $students[$i] = $student;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($student);
                            	$entityManager->flush();


                // actually executes the queries (i.e. the INSERT query)
                                $i++;
            }
            $em->remove($media1);
            $em->flush();

$entityMan->flush();
        }

        return $this->redirectToRoute('media_index');

    }



/**
     * Creates a new medium entity.
     *
     * @Route("/upload_csv/{id}", name="student_upload_csv")
     * @Method({"GET", "POST"})
     */


public function UploadCsv(Media $id, UserPasswordEncoderInterface $passwordEncoder )
{


        $students[] = new students();
        $media1 = $id;
        $nom_exel='students';
        $em = $this->getDoctrine()->getManager();
        
        $i=1;
        if($media1->getFilename()){
            require_once __DIR__.'/../../vendor/autoload.php';
          //  require_once __DIR__.'/../../public/uploads/media/'.''.$media1->getFilename();
            if (($handle = fopen(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename(), "r")) !== FALSE) {

                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);
                    //        echo "<p> $num champs à la ligne $i: <br /></p>\n";
                    /*
                    echo $data[$c] . "<br />\n";
                    }
                    */

                    if($i>1)
                    {
                        
                        
                        $em1 = $this->getDoctrine()->getManager();
                        $em2 = $this->getDoctrine()->getManager();
                        $em3 = $this->getDoctrine()->getManager();
                        //etablissement
                        $ets = $data[0];
                        $etablissementGet = strtoupper($ets);
                        $etablissement = $em1->getRepository('App:Etablissements')->findOneBy(array(

                            'sigle' => $etablissementGet));

                            //niveau

                            $niveauGet =  $data[1];
                            $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                                'name' => $niveauGet));
                                if(empty($niveau)){
                                    $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                                        'name' => strtoupper($niveauGet)));
                                        if(empty($niveau)){
                                            $niveau = $em2->getRepository('App:Niveau')->findOneBy(array(
                                                'name' => strtolower($niveauGet)));
                                            }
                                        }

                                        //classes

                                        $classeGet =  $data[2];
                                        $classes = $em3->getRepository('App:Classes')->findOneBy(array(

                                            'name' => $classeGet, 'etablissements' => $etablissement, 'niveau' => $niveau));

                                            if(empty($classes)){

                                                $classes = $em3->getRepository('App:Classes')->findOneBy(array(
                                                     'name' => strtolower($classeGet), 'etablissements' => $etablissement, 'niveau' => $niveau)); 

                            
                                                     if(empty($classes)){
                                                         $classes = $em3->getRepository('App:Classes')->findOneBy(array(
                                                             'name' => strtoupper($classeGet), 'etablissements' => $etablissement, 'niveau' => $niveau));
                                                            }
                                                        }
                
                                                        if(!empty($classes))
                                                        {

                                                            $student= new Students;
                                                            $student->setClasses($classes);
                                                            $student->setMatricule($data[3]);
                                                            $student->setName(strval(utf8_encode($data[4]))) ;
                                                            if(!empty($data[5]))
                                                            {
                                                                
                                                                $student->setFirstName(strval(utf8_encode($data[5]))) ;

                                                            }
                                                            else{
                                                                $student->setFirstName('non definie') ;

                
                                                            }

                                                            $student->setResponsable(strval($data[6])) ;
                                                            $student->setTelResponsable(intval($data[7])) ;

                                                            $student->setEmailResponsable($data[8]) ;
                                                            
                                                            if(!empty($data[9]) )
                                                            {
                                                                $student->setNouveau($data[9]) ;
                                                            }
                                                            else
                                                            {
                                                                $student->setNouveau('non defini') ;
                                                            }

                                                            if(!empty($data[10])  ) 
                                                            {
                                                                $student->setRedoublant($data[10]) ;
                                                            }
                                                            else
                                                            {
                                                                $student->setRedoublant('non defini') ;
                                                            }
                           //     $student->setRedoublant(("Z$i")->getValue() ) ;
                           if(!empty($data[11])) 
                           {
                               $student->setEtudeDossier($data[11]) ;
                            }
                            else
                            {
                                $student->setEtudeDossier('non defini') ;
                            }
                
                            $student->setPere(strval(utf8_encode($data[12]))) ;
                            $student->setMere(strval(utf8_encode($data[13]))) ;
                            $student->setTuteur(strval(utf8_encode($data[14])));
                            $student->setTelPere($data[15]) ;
                            $student->setTelMere($data[16]) ;
                            $student->setTelTuteur($data[17]) ;
                            $student->setEmailPere(strval(utf8_encode($data[18]))) ;
                            $student->setEmailMere(strval(utf8_encode($data[19]))) ;
                            $student->setEmailTuteur(strval(utf8_encode($data[20]))) ;
                            $student->setProfPere(strval(utf8_encode($data[21]))) ;
                            $student->setProfMere(strval(utf8_encode($data[22]))) ;
                            $student->setProfTuteur(strval(utf8_encode($data[23]))) ;
                            $student->setResidenceParents(strval(utf8_encode($data[24]))) ;
                            $student->setProche1(strval(utf8_encode($data[25]))) ;
                            $student->setTelProche1($data[26] ) ;
                            $student->setProche2($data[27]) ;
                            $student->setTelProche2($data[28]) ;
                            $student->setProche3(strval(utf8_encode($data[29]))) ;
                            $student->setTelProche3($data[30]) ;
                            
                            //   $student->setEtudeDossier(("AA$i")->getValue() ) ;

                            $excel_date = $data[31]; //here is that value 41621 or 41631
                            //$unix_date = ($excel_date - 25569) * 86400;
                            //$excel_date = 25569 + ($unix_date / 86400);
                            //$unix_date = ($excel_date - 25569) * 86400;
                            // echo gmdate("Y-m-d", $unix_date);
                            $newDate = date($excel_date);
                            // var_dump(gmdate("Y-m-d", $unix_date));

                            if (!empty(($data[31]))) {
                                //$dateTimeObject = \PHPExcel_Shared_Date::ExcelToPHPObject($excel_date);
                                // var_dump($dateTimeObject->format('Y-M-d'));
                                // echo $dateTimeObject->format('Y-M-d'), PHP_EOL;
                                //  $student->setAnneeNais(new \datetime($dateTimeObject->format('Y-M-d'))) ;
                                $student->setAnneeNais($newDate) ;
                                
                }


                $student->setLieuDeNaissance($data[32]) ;
                $student->setSexe($data[33]) ;
                $student->setCycle($data[34]) ;
                $student->setSerie($data[35] ) ;
                $student->setMoyPassageClasse(floatval( $data[36])) ;
                $student->setRang($data[37]) ;
                $student->setLastSchool($data[38]) ;
                $student->setNameChefLastSchool($data[39]) ;
                $student->setGroupeSanguin($data[40]) ;
                $student->setPathogieParticuliere($data[41] ) ;
                $student->setAllergieAlimentaire($data[42]) ;
                $student->setAllergieMedicamenteuse($data[43]) ;
                $student->setDispense($data[44]) ;
                $student->setMedecinFamiliale($data[45]) ;
                $student->setTelMedecinFamiliale($data[46]) ;
                $student->setAssuranceFamille($data[47]) ;
                $student->setHopitalAgree($data[48]) ;
                $student->setRhesus($data[49]) ;
                $student->setInaptitude($data[50]) ;
                $student->setFilename($data[51]) ;

                //inset $column_A_Value value in DB query here
                $name='';
                //$name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                $entityMan = $this->getDoctrine()->getManager();
                
                $user = $entityMan->getRepository('App:User')->findOneBy(array('phoneNumber'=>$student->getTelResponsable()));
                $users=[];

                if( $user == null && !empty($student->getTelResponsable())){
                    $user1=new User();
                    $user1->setUsername($student->getTelResponsable());
                    $user1->setPhoneNumber($student->getTelResponsable());
                    $user1->setEmail($student->getTelResponsable());
//                    $user1->setPlainPassword($student->getTelResponsable());
                    $user1->setPassword($passwordEncoder->encodePassword(
                    $user1,$student->getTelResponsable()));
                    $user1->setRoles(array('ROLE_PARENT'));
                    $user1->setEnabled("1");
                    $entityMan->persist($user1);
                    $entityMan->flush();    
                    
                }



                $entityManager = $this->getDoctrine()->getManager();

                $students[$i] = $student;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($student);
                if($i%100==0){
                $entityManager->flush();
                	

                }
                


                // actually executes the queries (i.e. the INSERT query)
                
            }
        }
       
            
                  $i++;
                }

                // $em->remove($media1);
                if(!empty($entityManager))
                {
	$entityManager->flush();
}
				if(!empty($entityMan))
				{
                	$entityMan->flush();		
                }
                $em->flush();
        }

    }

    fclose($handle);
    
    //        return $this->redirectToRoute('media_index');
    return $this->render('base.html.twig');
}

    /**
     * @Route("/upl/{id}",name="mediaStudent")
     * 
     * 
     */
    public function upload(Media $id,UserPasswordEncoderInterface $passwordEncoder) {
        $media1 = $id;
           if($media1->getFilename()){
            require_once __DIR__.'/../../vendor/autoload.php';
          //  require_once __DIR__.'/../../public/uploads/media/'.''.$media1->getFilename();
            if (($handle = fopen(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename(), "r")) !== FALSE) {
                $i = 0;
                
                        $em1 = $this->getDoctrine()->getManager();
                        $em2 = $this->getDoctrine()->getManager();
                        $em3 = $this->getDoctrine()->getManager();
                        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    
                            $num = count($data);
                    //        echo "<p> $num champs à la ligne $i: <br /></p>\n";
                    /*
                    echo $data[$c] . "<br />\n";
                    }
                    */
                    if($i==0){
                        $enTetes = $data;
                    }
                    if($i>1)
                    {
                        $student = new Students();
                        $j = 0;
                        
                        
                       $donnees = array_combine($enTetes, $data);
                        foreach ($enTetes as $key => $value) {
                            if(property_exists($student, lcfirst($value) )){
                                
                                    if (strtolower($value) == 'classes' or strtolower($value) == 'classe'){
                                        $classes = $em1->getRepository("App:Classes")->findOneBy(array( 'name' => $donnees['classes'],
                                            'etablissements'=>$em1->getRepository("App:Etablissements")->findOneBy(array( 'sigle' => $donnees['sigle'])),
                                            'niveau'=>$em1->getRepository("App:Niveau")->findOneBy(array( 'name' => $donnees['niveau']))));
                                    $method = 'setClasses';
                                    if(!empty($classes)){
                                    if(method_exists($student , $method)){
                                        $student->$method(($classes));
                                    }    
                                    }
                                    
                                
                            
                                }
                                else{
                                    if((lcfirst(strtolower($value))) == 'datedenaissance'){
                                          $method = 'set'.ucfirst($value);
                                if(method_exists($student , $method) && !empty($data[$j]))
                                {
                                        try{
                                           // $date = date_create_from_format("d/m/Y", $data[$j])->format("d-m-Y");      
                                            $date = date_create_from_format("d/m/Y", $data[$j]);
                                            if ($date != FALSE){
                                                $d=$date->format("d-m-Y");
                                                 $student->$method(new \DateTime($d));


                                                
                                            }
                                        } catch (Exception $ex) {
                                            echo 'erreur au niveau de la date';

                                        }
                                
                            
                                }
                                    
                                    }
                                    else if(strtolower ($value)== 'moypassageclasse'){
                                        
                                $method = 'set'.ucfirst($value);
                                if(method_exists($student , $method))
                                $student->$method(floatval(utf8_encode($data[$j])));
                               
                                    }
                                else{
                                $method = 'set'.ucfirst($value);
                                if(method_exists($student , $method))
                                $student->$method(strval(utf8_encode($data[$j])));
                               
                                }
                                 }
                            }
                            $j++;
                            }
                            //var_dump($student);
                           // dump($student);
                            
                $entityMan = $this->getDoctrine()->getManager();
                
                $user = $entityMan->getRepository('App:User')->findOneBy(array('phoneNumber'=>$student->getTelResponsable()));

                if( $user == null && !empty($student->getTelResponsable())){
                	$user1=new User();
                    $user1->setUsername($student->getTelResponsable());
                    if(!empty($student->getTelResponsable())){
                        $user1->setPhoneNumber($student->getTelResponsable());                        
                    } else if(!empty ($student->getTelPere())){
                        $user1->setPhoneNumber($student->getTelPere());
                    }
                   else if(!empty ($student->getTelMere())){
                        $user1->setPhoneNumber($student->getTelMere());
                    }
                    if(!empty($student->getEmailResponsable())){
                        $user1->setEmail($student->getEmailResponsable());
                    } else if(!empty($student->getEmailPere())){
                        $user1->setEmail($student->getEmailPere());
                        $student->setEmailResponsable($student->getEmailPere());
                    }
                     else if(!empty($student->getEmailMere())){
                        $user1->setEmail($student->getEmailMere());
                        $student->setEmailMere($student->getEmailMere());
                    }
                    else {
                        $user1->setEmail($student->getTelResponsable());
                    }
                    
                    //$user1->setPlainPassword($student->getTelResponsable());
                     $user1->setPassword($passwordEncoder->encodePassword(
                    $user1,$student->getTelResponsable()));
                    $user1->setRoles(array('ROLE_PARENT'));
                    $user1->setEnabled("1");
                    $entityMan->persist($user1);
                    $entityMan->flush();    
                    
                }
               $em1->persist($student);
               $em1->flush();

};
                        
                     
                     
                                                 
        $i++;  }
            
                
                }
                
                
                // $em->remove($media1);
           }

  
    fclose($handle);
    return $this->render('base.html.twig');
    
                                }  
   
                                

    /**
     * Creates a new student entity.
     *
     * @Route("/new", name="students_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
                                
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user1 = new User();

        $student = new Students();
       // $form = $this->createForm('App\Form\StudentsType', $student);
        $form = $this->createForm(StudentsType::class, $student,  [
            'dev' => $this->getUser()->getEtablissements()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $file = $form->get('file')->getData();
            if (!empty($file)){           
                $student->setFilename($file->getClientOriginalName());     
            }
            $em->persist($student);
            $em->flush();
             if (!empty($file)){           
            $name = "file".$student->getId().'.'.$file->guessExtension();
            $directory = __DIR__."/../../public/uploads/media/students";
            $student->setFilename($name);
            $file->move($directory, $name);
            $em->persist($student);
            $em->flush();


            }
            $em->persist($student);
            $em->flush();
            $user = $em->getRepository('App:User')->findOneBy(array('phoneNumber'=>$form['telResponsable']->getData()));
            if($user == null && !empty($form['telResponsable']->getData())){
                $user1->setUsername($form['telResponsable']->getData());
                $user1->setPhoneNumber($form['telResponsable']->getData());
                if(!empty($form['emailResponsable'])){
                    $user2 = $em->getRepository('App:User')->findOneBy(array(
                        'email'=>$form['emailResponsable']->getData()));
                    if(empty($user2)){
                        $user1->setEmail($form['emailResponsable']->getData());
                    }
                        else{
                            $user1->setEmail('non defini');
                        }

                }
                else
                {
$user1->setEmail('non defini');
                
                }
                //$user1->setPassword($passwordEncoder->encodePassword($user1,$form['telResponsable']->getData()));
                 $user1->setPassword($passwordEncoder->encodePassword(
                    $user1,$student->getTelResponsable()));
                $user1->setRoles(array('ROLE_PARENT'));
                $em->persist($user1);
                $em->flush();

            }
            return $this->redirectToRoute('students_show', array('id' => $student->getId()));
        }

        return $this->render('students/new.html.twig', array(
            'student' => $student,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a student entity.
     *
     * @Route("/{id}", name="students_show")
     * @Method("GET")
     */
    public function showAction(Students $student)
    {
        $deleteForm = $this->createDeleteForm($student);
        $em = $this->getDoctrine()->getManager();
        $notes = $em->getRepository('App:Notes')/*->findBy(
            array('students' => $student));*/
        ->createQueryBuilder('n')
        ->where('n.students =:student')
        ->setParameter('student', $student)
        /*->orderBy('n.nameEvaluation')
        ->orderBy('n.coeff')*/
        ->addOrderBy('n.nameEvaluation')
        ->addOrderBy('n.coeff')
        //dump($qb);
        ->getQuery()->getResult();

        //discipline
        $discipline = $em->getRepository('App:Facteurs_disciplinaires')->findBy(
            array('students' => $student),['motif'=>"asc",]);
    foreach ($discipline as $disc=>$val){
        $tab_motif[]=$val->getMotif();
    }
   
 if(!empty($tab_motif)){
            $motif= $tab_motif;
 }else{
     $motif=[];
 }
     
        //distinctions
        $distinctions = $em->getRepository('App:Distinction')->findBy(
            array('student' => $student));

        //Decision du conseil de classe
        
        $conseil = $em->getRepository('App:DecisionConseilDeClasse')->findBy(
            array('student' => $student));
        
        $programme = $em->getRepository('App:Programme')->findBy(
            array('niveau' => $student->getClasses()->getNiveau()));

        $lacunes = $student->getLacunes();

        $suggestions = $em->getRepository('App:Suggestions')->findBy(
            array('niveau' => $student->getClasses()->getNiveau()));
        
        $homework = $em->getRepository('App:Devoir')->findBy(
            array('class' => $student->getClasses()));



        
        //all notes
        $all_notes = $em->getRepository('App:Notes')->findAll();


        return $this->render('students/show.html.twig', array(
            'student' => $student,
            'discipline' => $discipline,
            'distinctions'=>$distinctions,
            'notes'=> $notes,
            'homework'=> $homework,
            'lacunes'=> $lacunes,
            'suggestions'=> $suggestions,
            'conseil'=> $conseil,
            'programme'=>$programme,
            'all_notes'=> $all_notes,
            'motifs'=>$motif,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays a student entity.
     *
     * @Route("/bulletin/{id}", name="bulletin_show")
     * @Method("GET")
     */
    public function bulletinAction(Students $student)
    {
        $deleteForm = $this->createDeleteForm($student);
        $em = $this->getDoctrine()->getManager();
        $notes = $em->getRepository('App:Notes')/*->findBy(
            array('students' => $student));*/
        ->createQueryBuilder('n')
            ->where('n.students =:student')
            ->setParameter('student', $student)
            /*->orderBy('n.nameEvaluation')
            ->orderBy('n.coeff')*/
            ->addOrderBy('n.nameEvaluation')
            ->addOrderBy('n.module')
            //dump($qb);
            ->getQuery()->getResult();

        $effectif_eleve = $em->getRepository('App:Students')
            ->findBy(array('classes'=>$student->getClasses()));
        $eff = count($effectif_eleve);

        $enseignants_titulaire = $em->getRepository('App:Enseignants_titulaire')
            ->findBy(array('classes'=>$student->getClasses()));

        $notesmodule = $em->getRepository('App:Notes')/*->findBy(
            array('students' => $student));*/
        ->createQueryBuilder('n')
            //->select('DISTINCT (trim(upper(`n.module`)))')
            ->select('DISTINCT n.module')
            ->where('n.module IS NOT NULL')
            ->andwhere('n.students =:student')
            ->setParameter('student', $student)
            ->addOrderBy('n.module')
            //->DISTINCT()
            ->getQuery()->getResult();
        /*dump($notesmodule);
        die();*/

        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('students/bulletin.html.twig', array(
            'student'=>$student,
            'notes'=>$notes,
            'eff'=>$eff,
            'enseignants_titulaire'=>$enseignants_titulaire,
            'notesmodule'=>$notesmodule
            //..Send some data to your view if you need to //
        ));

  //$snappy->setOption('header-html', 'pdf/header.html.twig');
        $filename = $student->getName().'_'.$student->getClasses().'_'.$student->getClasses()->getEtablissements();

        return new Response(
            $snappy
                ->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                //'Content-Disposition: attachment; filename="'.$filename.'.pdf"'
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )

        );
    }



    /**
     * Displays a form to edit an existing student entity.
     *
     * @Route("/{id}/edit", name="students_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Students $student)
    {
        $deleteForm = $this->createDeleteForm($student);
        $editForm = $this->createForm('App\Form\StudentsType', $student,[
                        'dev' => $this->getUser()->getEtablissements()

        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em =  $this->getDoctrine()->getManager();

             $file = $editForm->get('file')->getData();
            if (!empty($file)){           
                $student->setFilename($file->getClientOriginalName());     
            }
            $em->persist($student);
            $em->flush();
            $name = "file".$student->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/student";
            $student->setFilename($name);
            $file->move($directory, $name);
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('students_show', array('id' => $student->getId()));
        }

        return $this->render('students/edit.html.twig', array(
            'student' => $student,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a student entity.
     *
     * @Route("/delete/{id}", name="students_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, Students $student)
    {
       /* $form = $this->createDeleteForm($student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
            $classe = $student->getClasses()->getId();
            $ets = $student->getClasses()->getNiveau();
            $em->remove($student);
            $em->flush();
//        }

        return $this->redirectToRoute('students_index_class',[
            'flo'=>$classe,
            'dev'=>$ets
        ]);
    }

    /**
     * Creates a form to delete a student entity.
     *
     * @param Students $student The student entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Students $student)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('students_delete', array('id' => $student->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Creates a form to delete a note entity.
     *
     * @param Notes $note The note entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteNotesForm(Notes $note)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notes_delete', array('id' => $note->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
