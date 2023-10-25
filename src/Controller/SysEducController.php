<?php

namespace App\Controller;

use App\Entity\SysEduc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Matieres;
use App\Entity\User;
use App\Entity\Addresses;
use App\Entity\Media;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPExcel_IOFactory;

/**
 * Syseduc controller.
 *
 * @Route("syseduc")
 */
class SysEducController extends AbstractController
{
    /**
     * Lists all sysEduc entities.
     *
     * @Route("/", name="syseduc_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sysEducs = $em->getRepository('App:SysEduc')->findAll();

        return $this->render('syseduc/index.html.twig', array(
            'sysEducs' => $sysEducs,
        ));
    }


    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="syseduc_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadSyseducAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('syseduc_upload', array('id' => $media->getId()));
        }


        $syseducs[] = new Syseduc();
        $media1 =new Media();
        $nom_exel='SysEduc';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'système éducatif'));

        require_once __DIR__.'/../../../vendor/autoload.php';

        if($media1!=null){
            header('Content-Type: application/msexcel; charset=UTF-8');
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
                $syseduc = new SysEduc();

                $syseduc->setName($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $syseduc->setDescription($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $syseducs[$i] = $syseduc;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($syseduc);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'syseducs' => $syseducs,
            'form' => $form->createView(),
        ));

    }



    /**
     * Creates a new sysEduc entity.
     *
     * @Route("/new", name="syseduc_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sysEduc = new Syseduc();
        $form = $this->createForm('App\Form\SysEducType', $sysEduc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sysEduc);
            $em->flush();

            return $this->redirectToRoute('syseduc_show', array('id' => $sysEduc->getId()));
        }

        return $this->render('syseduc/new.html.twig', array(
            'sysEduc' => $sysEduc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sysEduc entity.
     *
     * @Route("/{id}", name="syseduc_show")
     * @Method("GET")
     */
    public function showAction(SysEduc $sysEduc)
    {
        $deleteForm = $this->createDeleteForm($sysEduc);

        return $this->render('syseduc/show.html.twig', array(
            'sysEduc' => $sysEduc,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sysEduc entity.
     *
     * @Route("/{id}/edit", name="syseduc_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SysEduc $sysEduc)
    {
        $deleteForm = $this->createDeleteForm($sysEduc);
        $editForm = $this->createForm('App\Form\SysEducType', $sysEduc);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('syseduc_show', array('id' => $sysEduc->getId()));
        }

        return $this->render('syseduc/edit.html.twig', array(
            'sysEduc' => $sysEduc,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sysEduc entity.
     *
     * @Route("/{id}", name="syseduc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SysEduc $sysEduc)
    {
        $form = $this->createDeleteForm($sysEduc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sysEduc);
            $em->flush();
        }

        return $this->redirectToRoute('syseduc_index');
    }

    /**
     * Creates a form to delete a sysEduc entity.
     *
     * @param SysEduc $sysEduc The sysEduc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SysEduc $sysEduc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('syseduc_delete', array('id' => $sysEduc->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
