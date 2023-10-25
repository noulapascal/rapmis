<?php

namespace App\Controller;

use App\Entity\SectionEduc;
use App\Entity\Type_etablissements;
use App\Repository\EtablissementsRepository;
use App\Entity\Etablissements;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\City;
use App\Entity\Department;
use App\Form\EtablissementsType;
use App\Entity\Country;
use App\Entity\Regions;
use App\Entity\Addresses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;
use App\Entity\Subdivision;
use App\Form\RegSelType;

/**
 * Etablissement controller.
 *
 * @Route("etablissements/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml",
 * })
 */
class EtablissementsController extends AbstractController
{
    /**
     * Lists all etablissement entities.
     *
     * @Route("/", name="etablissements_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAll();
        $an = $em->getRepository('App:SchoolYear')->findAll();

        return $this->render('etablissements/index.html.twig', array(
            'etablissements' => $etablissements,
            'schoolYear'=>$an
        ));
    }



    /**
     * Lists all etablissement entities.
     *
     * @Route("/see", name="etablissements_see")
     * @Method("GET")
     */
    public function seeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findAll();

        return $this->render('etablissements/index.html_1.twig', array(
            'etablissements' => $etablissements,
        ));
    }

  /**
     * Lists all etablissement entities.
     *
     * @Route("/school/{id}", name="etablissements_sub_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_ARR') or is_granted('ROLE_SUPER_ADMIN')")
     */  
    public function schoolAction(Subdivision $flo)
    {
        $em = $this->getDoctrine()->getManager();
if(!empty($this->getUser()->getTypeEtablissement())){
        $etablissements = $em->getRepository('App:Etablissements')->findBy([
            'subdivision'=>$flo,
            'type_etablissements'=>$this->getUser()->getTypeEtablissement()
]);}

else{
        $etablissements = $em->getRepository('App:Etablissements')->findBy([
            'subdivision'=>$flo
        ]);

}
$an = $em->getRepository('App:SchoolYear')->findAll();

    
        return $this->render('viewer/city/index_shool.html.twig', array(
            'etablissements' => $etablissements,
            'schoolYear'=>$an
        ));
    }


    /**
     * Lists all etablissement entities.
     *
     * @Route("/reg/{id}", name="etablissements_reg_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_REGION')")
     */
    public function regAction(Regions $id)
    {
        $em = $this->getDoctrine()->getManager();
        $departments = $id->getDepartments();
        foreach ($departments as $key => $value) {
            /*@param Department $value*/
            $cities = $value->getCity();

        }
        
        foreach ($cities as $key => $value) {
            $etablissements[] = $em->getRepository('App:Etablissements')->findBy([
                'type_etablissements'=> $this->getUser()->getTypeEtablissement(),
            'city'=>$value]
                    );
        }
        if (!empty($etablissements))
        {
            
        return $this->render('viewer/etablissements/index_reg.html.twig', array(
            'etablissements' => $etablissements ? $etablissements : []
        ));
        } 
        else{
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' =>[]));
        }
            
    }



    /**
     * Lists all etablissement entities.
     *
     * @Route("/reg_seduc_action/{id}", name="etablissements_reg_seduc_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_SEDUC_REG')")
     */
    public function regSeducAction(Regions $id)
    {
        $em = $this->getDoctrine()->getManager();
        $departments = $id->getDepartments();
        foreach ($departments as $key => $value) {
            /*@param Department $value*/
            $cities = $value->getCity();

        }
        
        foreach ($cities as $key => $value) {
            $etablissements[] = $em->getRepository('App:Etablissements')->findBy([
                'type_etablissements'=> $this->getUser()->getTypeEtablissement(),
                'sectionEduc'=> $this->getUser()->getObedience(),
            'city'=>$value]
                    );
        }
        if (!empty($etablissements))
        {
            
        return $this->render('viewer/etablissements/index_reg.html.twig', array(
            'etablissements' => $etablissements ? $etablissements : []
        ));
        } 
        else{
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' =>[]));
        }
            
    }



    /**
     * Lists all etablissement entities.
     *
     * @Route("/seduc/{id}", name="etablissements_seduc_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_SEDUC_REG')")
     */
    public function seducAction(Regions $id)
    {
        $em = $this->getDoctrine()->getManager();
        $departments = $id->getDepartments();
        foreach ($departments as $key => $value) {
            /*@param Department $value*/
            $cities = $value->getCity();

        }
        
        foreach ($cities as $key => $value) {
            $etablissements[] = $em->getRepository('App:Etablissements')->findBy([
                'type_etablissements'=> $this->getUser()->getTypeEtablissement(),
            'sectioneduc'=>$value,
            'city'=>$value]
                    );
        }
        if (!empty($etablissements))
        {
            
        return $this->render('viewer/etablissements/index_reg.html.twig', array(
            'etablissements' => $etablissements ? $etablissements : []
        ));
        } 
        else{
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' =>[]));
        }
            
    }

    /**
     * Lists all etablissement entities.
     *
     * @Route("/dept/{id}", name="etablissements_dept_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_DEPT')")
     */
    public function deptAction(Department $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $id->getCity();
        foreach ($cities as $key => $value) {
            $etablissements[] = $em->getRepository('App:Etablissements')->findBy([
            'city'=>$value,
                'type_etablissements'=> $this->getUser()->getTypeEtablissement(),
                            'sectionEduc'=> $this->getUser()->getObedience(),
]);


        }
               if (!empty($etablissements))
        {
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' => $etablissements ? $etablissements : []
        ));
        } 
        else{
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' =>[]));
        }
            
    }

    /**
     * Lists all etablissement entities.
     *
     * @Route("/seduc_dept/{id}", name="etablissements_seduc_dept_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_SEDUC_DEPT')")
     */
    public function seducDeptAction(Department $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $id->getCity();
        foreach ($cities as $key => $value) {
            $etablissements[] = $em->getRepository('App:Etablissements')->findBy([
            'city'=>$value,
                'type_etablissements'=> $this->getUser()->getTypeEtablissement()]);

        }
               if (!empty($etablissements))
        {
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' => $etablissements ? $etablissements : []
        ));
        } 
        else{
            
        return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' =>[]));
        }
            
    }


    
    
    /**
     * Lists all etablissement entities.
     *
     * @Route("/inspect/{id}", name="etablissements_inspect_index")
     * @Method("GET")
     * @Security("is_granted('ROLE_ARR')")
     */
    public function viewerAction(Subdivision $id)
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('App:Etablissements')->findBy([
            'subdivision'=>$id,
            'type_etablissements'=> $this->getUser()->getTypeEtablissement()
        ]);

        return $this->render('admin/etablissements/index.html.twig', array(
            'etablissements' => $etablissements? $etablissements : []
        ));
    }

    
    /**
     * Creates a new media entity.
     *
     * @Route("/upload", name="etablissements_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadEtablissementsAction(Request $request){

        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('etablissements_upload', array('id' => $media->getId()));
        }
        //debut city
        $etablissements[] = new Etablissements();
        $media1 =new Media();
        $nom_exel='etablissements';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'etablissements'));


        require_once __DIR__.'/../../../vendor/autoload.php';

        if($media1!=null){
            //ini_set('mbstring.substitute_character', "none");
            header('Content-Type: application/msexcel; charset=UTF-8');

            require_once __DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename();
            $objReader = PHPExcel_IOFactory::createReaderForFile(__DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename());
            //$objReader->setReadDataOnly(false); //optional



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
                //you can add your own columns B, C, D etc. Sectioneduc
                $country = new Country();
                $region = new regions();
                $department = new Department();
                $city = new City();
                $etablissement = new Etablissements();
                $addresse = new Addresses();
                $typeEtablissements = new Type_etablissements();
                $sectioneduc = new SectionEduc();


                $country->setName($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $country->setCapital($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());
                $em1 = $this->getDoctrine()->getManager();
                $coun = $em1->getRepository('App:Country')->findOneBy(array(
                    'name' => $country->getName()));

                $region->setName($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue());
                $region->setChefLieu($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue());
                $region->setCountry($coun);

                $reg = $em1->getRepository('App:Regions')->findOneBy(array(
                    'name' => $region->getName()));
                $department->setName($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue());
                $department->setChefLieu($objPHPExcel->getActiveSheet()->getCell("F$i")->getValue());
                $department->setRegions($reg);

                $depart = $em1->getRepository('App:Department')->findOneBy(array(
                    'name' => $department->getName()));
                $city->setName($objPHPExcel->getActiveSheet()->getCell("G$i")->getValue());
                $city->setDepartments($depart);

                $cit = $em1->getRepository('App:City')->findOneBy(array(
                    'name' => $city->getName()));
                $etablissement->setName($objPHPExcel->getActiveSheet()->getCell("H$i")->getValue());
                $etablissement->setSigle($objPHPExcel->getActiveSheet()->getCell("I$i")->getValue());
                $etablissement->setDescription($objPHPExcel->getActiveSheet()->getCell("J$i")->getValue());
                $etablissement->setDateCreation($objPHPExcel->getActiveSheet()->getCell("K$i")->getValue());
                $etablissement->setFilename($objPHPExcel->getActiveSheet()->getCell("L$i")->getValue());

                $addresse->setEmail($objPHPExcel->getActiveSheet()->getCell("M$i")->getValue());
                $addresse->setTel($objPHPExcel->getActiveSheet()->getCell("N$i")->getValue());
                $addresse->setBP($objPHPExcel->getActiveSheet()->getCell("O$i")->getValue());
                $addresse->setFax($objPHPExcel->getActiveSheet()->getCell("P$i")->getValue());
                $addresse->setLongitude($objPHPExcel->getActiveSheet()->getCell("Q$i")->getValue());
                $addresse->setLatitude($objPHPExcel->getActiveSheet()->getCell("R$i")->getValue());
                $etablissement->setAdresses($addresse);

                $typeEtablissements->setName($objPHPExcel->getActiveSheet()->getCell("S$i")->getValue());
                $typeEtablissements->setDescription($objPHPExcel->getActiveSheet()->getCell("T$i")->getValue());
                $etablissement->setTypeEtablissements($typeEtablissements);

                $sectioneduc->setName($objPHPExcel->getActiveSheet()->getCell("S$i")->getValue());
                $sectioneduc->setName($objPHPExcel->getActiveSheet()->getCell("S$i")->getValue());

                $etablissement->setSectioneduc(array($sectioneduc));
                $etablissement->setCity($cit);

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                $entityManager = $this->getDoctrine()->getManager();

                $etablissements[$i] = $etablissement;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($etablissement);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'etablissements' => $etablissements,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new etablissement entity.
     *
     * @Route("/new", name="etablissements_new")
     */
    public function newAction(Request $request)
    {
        $etablissement = new Etablissements();
        $form = $this->createForm('App\Form\EtablissementsType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etablissement->setCity($form['city']->getData());
            $sigle=$form['sigle']->getData();
            $sigle=strtoupper($sigle);
            $etablissement->setSigle($sigle);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new etablissement secondaire entity.
     *
     * @Route("/news/{who}", name="etablissements_news")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newsAction(Request $request, $who)
    {
        $etablissement = new Etablissements();
        $etablissement->setDateCreation(new \DateTime());
        $etablissement->setType_Etablissements($this->getDoctrine()
            ->getRepository('App\Entity\Type_etablissements')
            ->findOneBy(array('name' => $who)));
        $form = $this->createForm(EtablissementsType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $sigle=$form['sigle']->getData();
            $sigle=strtoupper($sigle);
            $etablissement->setSigle($sigle);

            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a etablissement entity.
     *
     * @Route("/{id}", name="etablissements_show")
     * @Method("GET")
     */
    public function showAction(Etablissements $etablissement)
    {
        $deleteForm = $this->createDeleteForm($etablissement);

        return $this->render('etablissements/show.html.twig', array(
            'etablissement' => $etablissement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * select a regions of etablissement entity.
     *
     * @Route("/choose_region/", name="regions_choose")
     * @Method("GET")
     */
    public function selectAction(Request $request)
    {
        $selform = $this->createForm(RegSelType::class
                );
        $selform->handleRequest($request);
        if($selform->isSubmitted() && $selform->isValid()){
            $region = $selform['regions']->getData();
            return $this->redirectToRoute('etablissements_new');
        }
        
        return $this->render('user/index.html.twig', array(
          'form' => $selform->createView(),
          //  'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing etablissement entity.
     *
     * @Route("/{id}/edit", name="etablissements_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Etablissements $id,Request $request)
    {
        $etablissement = $id;
        $deleteForm = $this->createDeleteForm($etablissement);
        $editForm = $this->createForm('App\Form\EtablissementsType', $etablissement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etablissements_show', array('id' => $etablissement->getId()));
        }

        return $this->render('etablissements/edit.html.twig', array(
            'etablissement' => $etablissement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etablissement entity.
     *
     * @Route("/{id}", name="etablissements_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissements $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('etablissements_index');
    }

    /**
     * Creates a form to delete a etablissement entity.
     *
     * @param Etablissements $etablissement The etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etablissements $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etablissements_delete', array('id' => $etablissement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
