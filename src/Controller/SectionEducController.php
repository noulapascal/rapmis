<?php

namespace App\Controller;

use App\Entity\SectionEduc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Media;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPExcel_IOFactory;

/**
 * Sectioneduc controller.
 *
 * @Route("sectioneduc")
 */
class SectionEducController extends AbstractController
{
    /**
     * Lists all sectionEduc entities.
     *
     * @Route("/", name="sectioneduc_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sectionEducs = $em->getRepository('App:SectionEduc')->findAll();

        return $this->render('sectioneduc/index.html.twig', array(
            'sectionEducs' => $sectionEducs,
        ));
    }


    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="section_upload")
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
            return $this->redirectToRoute('section_upload', array('id' => $media->getId()));
        }


        $sectionEducs[] = new SectionEduc();
        $media1 =new Media();
        $nom_exel='SectionEduc';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'section éducatif'));

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
                $sectionEduc = new SectionEduc();

                $sectionEduc->setName($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $sectionEduc->setDescription($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $sectionEducs[$i] = $sectionEduc;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($sectionEduc);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'sectionEducs' => $sectionEducs,
            'form' => $form->createView(),
        ));

    }


    /**
     * Creates a new sectionEduc entity.
     *
     * @Route("/new", name="sectioneduc_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sectionEduc = new Sectioneduc();
        $form = $this->createForm('App\Form\SectionEducType', $sectionEduc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sectionEduc);
            $em->flush();

            return $this->redirectToRoute('sectioneduc_show', array('id' => $sectionEduc->getId()));
        }

        return $this->render('sectioneduc/new.html.twig', array(
            'sectionEduc' => $sectionEduc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sectionEduc entity.
     *
     * @Route("/{id}", name="sectioneduc_show")
     * @Method("GET")
     */
    public function showAction(SectionEduc $sectionEduc)
    {
        $deleteForm = $this->createDeleteForm($sectionEduc);

        return $this->render('sectioneduc/show.html.twig', array(
            'sectionEduc' => $sectionEduc,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sectionEduc entity.
     *
     * @Route("/{id}/edit", name="sectioneduc_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SectionEduc $sectionEduc)
    {
        $deleteForm = $this->createDeleteForm($sectionEduc);
        $editForm = $this->createForm('App\Form\SectionEducType', $sectionEduc);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectioneduc_show', array('id' => $sectionEduc->getId()));
        }

        return $this->render('sectioneduc/edit.html.twig', array(
            'sectionEduc' => $sectionEduc,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sectionEduc entity.
     *
     * @Route("/{id}", name="sectioneduc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SectionEduc $sectionEduc)
    {
        $form = $this->createDeleteForm($sectionEduc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sectionEduc);
            $em->flush();
        }

        return $this->redirectToRoute('sectioneduc_index');
    }

    /**
     * Creates a form to delete a sectionEduc entity.
     *
     * @param SectionEduc $sectionEduc The sectionEduc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SectionEduc $sectionEduc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sectioneduc_delete', array('id' => $sectionEduc->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
