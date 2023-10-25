<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Regions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Addresses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;

/**
 * Region controller.
 *
 * @Route("regions")
 */
class RegionsController extends AbstractController
{
    /**
     * Lists all region entities.
     *
     * @Route("/", name="regions_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regions = $em->getRepository('App:Regions')->findAll();

        return $this->render('regions/index.html.twig', array(
            'regions' => $regions,
        ));
    }
    /**
     * Lists all region entities.
     *
     * @Route("/min", name="regions_index_min")
     * @Method("GET")
     */
    public function indexMinAction()
    {
        $em = $this->getDoctrine()->getManager();

        
if($this->isGranted('ROLE_PAYS')){
    $regions = $em->getRepository('App:Regions')->findBy([
'country'=> $this->getUser()->getZone()
            ]);
        return $this->render('viewer/regions/index.html.twig', array(
            'regions' => $regions,
));
        
}
if($this->isGranted('ROLE_REGION')){
    $departments = $em->getRepository('App:Department')->findBy([
        'regions'=> $this->getUser()->getZone()
    ]);
        return $this->render('viewer/department/index.html.twig', array(
            'departments' => $departments,
));
        
}

if($this->isGranted('ROLE_DEPT')){
    $city = $em->getRepository('App:City')->findBy([
        'departments'=> $this->getUser()->getZone()
    ]);
        return $this->render('viewer/city/index.html.twig', array(
            'cities' =>$city ,
));
}    

if($this->isGranted('ROLE_ARR')){
    $ets = $em->getRepository('App:Etablissements')->findBy([
        'subdivision'=> $this->getUser()->getZone()
    ]);
    return $this->render('viewer/etablissements/index.html.twig', array(
            'etablissements' => $ets,
));
        

    }
    }


    /**
     * Creates a new media entity.
     *
     * @Route("/upload", name="regions_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadRegionsAction(Request $request){

        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('regions_upload', array('id' => $media->getId()));
        }
        //debut regions
        $regions[] = new regions();
        $media1 =new Media();
        $nom_exel='regions';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'regions'));


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
                //you can add your own columns B, C, D etc.
                $country = new Country();
                $region = new regions();

                $country->setName($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $country->setCapital($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());

                $em1 = $this->getDoctrine()->getManager();
                $coun = $em1->getRepository('App:Country')->findOneBy(array('name' => $country->getName()));

                $region->setName($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue());
                $region->setChefLieu($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue());
                $region->setCountry($coun);



                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                $entityManager = $this->getDoctrine()->getManager();

                $regions[$i] = $region;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->
                persist($region);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'regions' => $regions,
            'form' => $form->createView(),
        ));
    }



    /**
     * Creates a new region entity.
     *
     * @Route("/new", name="regions_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $region = new Regions();
        $form = $this->createForm('App\Form\RegionsType', $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('regions_show', array('id' => $region->getId()));
        }

        return $this->render('regions/new.html.twig', array(
            'region' => $region,
            'form' => $form->createView(),
        ));
    }

    
    
    
    /**
     * Lists all department per  regions.
     *
     * @Route("/{flo}", name="regions_department")
     * @Method("GET")
     */
    public function departmentAction(Regions $flo)
    {
        $em = $this->getDoctrine()->getManager();

        $departments = $em->getRepository('App:Department')->findBy([
            'regions'=>$flo
        ]);

        return $this->render('department/index.html.twig', array(
            'departments' => $departments,
            'flo'=>$flo,
        ));
    }
    /**
     * Finds and displays a region entity.
     *
     * @Route("/{id}", name="regions_show")
     * @Method("GET")
     */
    public function showAction(Regions $region)
    {
        $deleteForm = $this->createDeleteForm($region);

        return $this->render('regions/show.html.twig', array(
            'region' => $region,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing region entity.
     *
     * @Route("/{id}/edit", name="regions_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Regions $region)
    {
        $deleteForm = $this->createDeleteForm($region);
        $editForm = $this->createForm('App\Form\RegionsType', $region);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('regions_show', array('id' => $region->getId()));
        }

        return $this->render('regions/edit.html.twig', array(
            'region' => $region,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a region entity.
     *
     * @Route("/{id}", name="regions_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Regions $region)
    {
        $form = $this->createDeleteForm($region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($region);
            $em->flush();
        }

        return $this->redirectToRoute('regions_index');
    }

    /**
     * Creates a form to delete a region entity.
     *
     * @param Regions $region The region entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Regions $region)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regions_delete', array('id' => $region->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
