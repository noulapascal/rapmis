<?php

namespace App\Controller;

use App\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;


/**
 * Staff controller.
 *
 * @Route("staff")
 */
class StaffController extends AbstractController
{
    /**
     * Lists all staff entities.
     *
     * @Route("/", name="staff_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $staff = $em->getRepository('App:Staff')
            ->findBy(array('etablissements'=>$this->getUser()->getEtablissements()));

        return $this->render('staff/index.html.twig', array(
            'staff' => $staff,
        ));
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="staff_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadMatieresAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $media->setName('staff');
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('staff_upload', array('id' => $media->getId()));
        }


        $staffs[] = new Staff();
        $media1 =$media;
        $nom_exel='staff';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'staff'));

        require_once __DIR__.'/../../../vendor/autoload.php';
        
        if(!empty($media1)){
            //header('Content-Type: application/msexcel; charset=UTF-8');
            header("Content-Type: text/html; charset=utf-8");
            if(is_file('./uploads/media/'.''.$media1->getFilename())){
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

                $staff = new Staff();
                $em1 = $this->getDoctrine()->getManager();

                //etablissements
                $etsGet0 =  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();
                $etsGet = strtoupper($etsGet0);
                $ets = $em1->getRepository('App:Etablissements')->findOneBy(array(
                    'sigle'=>$etsGet
                ));
                if(empty($ets)){
                          $ets = $this->getUser()->getEtablissements();
                          }
                $staff->setEtablissements($ets);
                $staff->setName($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue() ) ;
                $staff->setFonction($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue() ) ;
                $staff->setTel($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue() ) ;
                $staff->setSexe($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue() ) ;
                $staff->setMail($objPHPExcel->getActiveSheet()->getCell("F$i")->getValue() ) ;
                $staff->setDateCreate($objPHPExcel->getActiveSheet()->getCell("G$i")->getValue() ) ;
                $staff->setFilename($objPHPExcel->getActiveSheet()->getCell("H$i")->getValue() ) ;

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();

                $entityManager = $this->getDoctrine()->getManager();

                $staffs[$i] = $staff;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($staff);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'staffs' => $staffs,
            'form' => $form->createView(),
        ));

    }



    /**
     * Creates a new staff entity.
     *
     * @Route("/new", name="staff_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $staff = new Staff();
        $staff->setEtablissements($this->getUser()->getEtablissements());
        $form = $this->createForm(\App\Form\StaffType::class    , $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();

            return $this->redirectToRoute('staff_show', array('id' => $staff->getId()));
        }

        return $this->render('staff/new.html.twig', array(
            'staff' => $staff,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a staff entity.
     *
     * @Route("/{id}", name="staff_show")
     * @Method("GET")
     */
    public function showAction(Staff $staff)
    {
        $deleteForm = $this->createDeleteForm($staff);

        return $this->render('staff/show.html.twig', array(
            'staff' => $staff,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing staff entity.
     *
     * @Route("/{id}/edit", name="staff_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Staff $staff)
    {
        $deleteForm = $this->createDeleteForm($staff);
        $editForm = $this->createForm('App\Form\StaffType', $staff);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('staff_show', array('id' => $staff->getId()));
        }

        return $this->render('staff/edit.html.twig', array(
            'staff' => $staff,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a staff entity.
     *
     * @Route("/delete/{id}", name="staff_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Staff $staff)
    {
      /*  $form = $this->createDeleteForm($staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        */    $em = $this->getDoctrine()->getManager();
            $em->remove($staff);
            $em->flush();
        //}

        return $this->redirectToRoute('staff_index');
    }

    /**
     * Creates a form to delete a staff entity.
     *
     * @param Staff $staff The staff entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Staff $staff)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('staff_delete', array('id' => $staff->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
