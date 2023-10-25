<?php

namespace App\Controller;

use App\Entity\Chef_department;
use App\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Matieres;
use App\Entity\User;
use App\Entity\Addresses;
use App\Entity\Media;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPExcel_IOFactory;


/**
 * Chef_department controller.
 *
 * @Route("chef_department/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml",
 * })
 */
class Chef_departmentController extends AbstractController
{
    /**
     * Lists all chef_department entities.
     *
     * @Route("/", name="chef_department_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('App:Teacher')
            ->findBy(array('etablissements'=>$this->getUser()->getEtablissements()));

        $chef_departments = $em->getRepository('App:Chef_department')
            ->createQueryBuilder('c')
            ->where('c.teacher IN (:teacher)')
            ->setParameter('teacher', $teacher)
            //dump($qb);
            ->getQuery()->getResult();
        //$chef_departments = $em->getRepository('App:Chef_department')->findAll();

        return $this->render('chef_department/index.html.twig', array(
            'chef_departments' => $chef_departments,
        ));
    }


    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="city_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadCityAction(Request $request){

        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('city_upload', array('id' => $media->getId()));
        }
        //debut adresses
        $city[] = new City();
        $media1 =new Media();
        $nom_exel='city';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'city'));

        /*$logo=new Logo();
        $em1 = $this->getDoctrine()->getManager();
        $logo = $em1->getRepository('NomoovBundle:Logo')->findOneBy(array('id' => '1'));*/


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
                $city = new addresses();

                $city->setEmail(  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $city->setBP($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());
                $city->setTel($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue());
                $city->setLongitude($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue());
                $city->setLatitude($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue());
                $city->setFax($objPHPExcel->getActiveSheet()->getCell("F$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                /* $user=new Utilisateurs();
                 $user->setEmail("$name@0.com");
                 $user->setUsername($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue());
                 $user->setPassword('0000');
                 $entreprise->setUtilisateur($user);*/
                //$entreprise->setLogo($logo);


                $entityManager = $this->getDoctrine()->getManager();

                $addresse[$i] = $city;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->
                persist($city);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'city' => $city,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new chef_department entity.
     *
     * @Route("/new", name="chef_department_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request)
    {
        $chef_department = new Chef_department();
        $form = $this->createForm('App\Form\Chef_departmentType', $chef_department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chef_department);
            $em->flush();

            return $this->redirectToRoute('chef_department_show', array('id' => $chef_department->getId()));
        }

        return $this->render('chef_department/new.html.twig', array(
            'chef_department' => $chef_department,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chef_department entity.
     *
     * @Route("/{id}", name="chef_department_show")
     * @Method("GET")
     */
    public function showAction(Chef_department $chef_department)
    {
        $deleteForm = $this->createDeleteForm($chef_department);

        return $this->render('chef_department/show.html.twig', array(
            'chef_department' => $chef_department,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chef_department entity.
     *
     * @Route("/{id}/edit", name="chef_department_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chef_department $chef_department)
    {
        $deleteForm = $this->createDeleteForm($chef_department);
        $editForm = $this->createForm('App\Form\Chef_departmentType', $chef_department);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chef_department_show', array('id' => $chef_department->getId()));
        }

        return $this->render('chef_department/edit.html.twig', array(
            'chef_department' => $chef_department,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chef_department entity.
     *
     * @Route("/{id}", name="chef_department_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chef_department $chef_department)
    {
        $form = $this->createDeleteForm($chef_department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chef_department);
            $em->flush();
        }

        return $this->redirectToRoute('chef_department_index');
    }

    /**
     * Creates a form to delete a chef_department entity.
     *
     * @param Chef_department $chef_department The chef_department entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chef_department $chef_department)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chef_department_delete', array('id' => $chef_department->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
