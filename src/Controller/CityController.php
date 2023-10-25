<?php

namespace App\Controller;

use App\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Department;
use App\Entity\Country;
use App\Entity\Regions;
use App\Entity\Addresses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;

/**
 * City controller.
 *
 * @Route("city/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml",
 * })
 */
class CityController extends AbstractController
{
    /**
     * Lists all city entities.
     *
     * @Route("/", name="city_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('App:City')->findAll();

        return $this->render('city/index.html.twig', array(
            'cities' => $cities,
        ));
    }

    /**
     * Lists all city entities.
     *
     * @Route("/school/{flo}", name="city_school")
     * @Method("GET")
     */
    public function schoolAction(City $flo)
    {
        $em = $this->getDoctrine()->getManager();
if(!empty($this->getUser()->getTypeEtablissement()))
{
    $etablissements = $em->getRepository('App:Etablissements')->findBy([
            'city'=>$flo,
        'type_etablissements'=>$this->getUser()->getTypeEtablissement()
        ]);
}
else{
        $etablissements = $em->getRepository('App:Etablissements')->findBy([
            'city'=>$flo
        ]);

}

$an = $em->getRepository('App:SchoolYear')->findAll();

dump(new \DateTime());
        return $this->render('city/index_shool.html.twig', array(
            'etablissements' => $etablissements,
            'flo' => $flo,
            'schoolYear' => $an
        ));
    }


    /**
     * Creates a new media entity.
     *
     * @Route("/upload", name="city_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadCityAction(Request $request) 
            {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            $mime=mime_content_type( __DIR__.'/../../../web/uploads/media/'.''.$media->getFilename());
            if(strpos($media->getFilename(), '.csv') or strpos($media->getFilename(), '.CSV') ){
            	return $this->redirectToRoute('city_csv_upload', array('id' => $media->getId()));
	
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
     * Creates a new media entity.
     *
     * @Route("/upload_csv/{id}", name="city_csv_upload")
     * @Method({"GET", "POST"})
     */
    
    public function upload(Media $id) {
        $media1 = $id;
           if($media1->getFilename()){
            require_once __DIR__.'/../../../vendor/autoload.php';
          //  require_once __DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename();
            if (($handle = fopen(__DIR__.'/../../../public/uploads/media/'.''.$media1->getFilename(), "r")) !== FALSE) {
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
                        $villes = new City();
                        $j = 0;
                        
                       $donnees = array_combine($enTetes, $data);
                        foreach ($enTetes as $key => $value) {
                            if(property_exists($villes, lcfirst($value))){
                                
                                    if (lcfirst($value) == 'departments'){
                                        $departments = $em1->getRepository("App:Department")->findOneBy(array( 'name' => $donnees[lcfirst($value)],
                                            ));
                                    $method = 'set'.ucfirst($value);
                                    if(!empty($departments)){
                                    if(method_exists($villes , $method)){
                                        $villes->$method(($departments));
                                    }    
                                    }
                                }
                                else{
                                    
                                $method = 'set'.ucfirst($value);
                                $city = $this->getDoctrine()->getManager()->getRepository('App:city')->findOneBy([
                                    "$value"=>$donnees[$value]
                                ]);
                                if(empty($city)){
                                    
                                if(method_exists($villes , $method))
                                $villes->$method(strval(utf8_encode($data[$j])));
                               
                                }
                                }
                                 }
                            
                            $j++;
                            }
                if(!empty($villes->getName())){
                $em1->persist($villes);
               $em1->flush();
                } 
                else{
                    $em1->flush();
                }
};
                        
                     
                     
                                                 
        $i++;  }
            
                
                }
                
                
                // $em->remove($media1);
           }

  
    fclose($handle);
    return $this->render('base.html.twig');
    }  
   
    
    /*
    public function uploadCitiesAction(Request $request){

        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('city_upload', array('id' => $media->getId()));
        }
        //debut city
        $cities[] = new City();
        $media1 =new Media();
        $nom_exel='city';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'city'));


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
                $department = new Department();
                $city = new City();

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

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                $entityManager = $this->getDoctrine()->getManager();

                $cities[$i] = $city;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($city);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'cities' => $cities,
            'form' => $form->createView(),
        ));
    }

*/

    /**
     * Creates a new city entity.
     *
     * @Route("/new", name="city_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm('App\Form\CityType', $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('city_show', array('id' => $city->getId()));
        }

        return $this->render('city/new.html.twig', array(
            'city' => $city,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a city entity.
     *
     * @Route("/{id}", name="city_show")
     * @Method("GET")
     */
    public function showAction(City $city)
    {
        $deleteForm = $this->createDeleteForm($city);

        return $this->render('city/show.html.twig', array(
            'city' => $city,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing city entity.
     *
     * @Route("/{id}/edit", name="city_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $editForm = $this->createForm('App\Form\CityType', $city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_show', array('id' => $city->getId()));
        }

        return $this->render('city/edit.html.twig', array(
            'city' => $city,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    /**
     * @Route("/subdivision/{flo}", name="city_subdivision")
     */

    
    public function cityAction(City $flo)
    {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('App:Subdivision')->findBy([
            'city'=>$flo
        ]);

        return $this->render('subdivision/index.html.twig', array(
            'cities' => $cities,
            'flo' => $flo,
        ));
    }

    /**
     * Deletes a city entity.
     *
     * @Route("/{id}", name="city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, City $city)
    {
        $form = $this->createDeleteForm($city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
        }

        return $this->redirectToRoute('city_index');
    }

    /**
     * Creates a form to delete a city entity.
     *
     * @param City $city The city entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
