<?php

namespace App\Controller;

use App\Entity\Type_etablissements;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Media;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPExcel_IOFactory;

/**
 * Type_etablissement controller.
 *
 * @Route("type_etablissements")
 */
class Type_etablissementsController extends AbstractController
{
    /**
     * Lists all type_etablissement entities.
     *
     * @Route("/", name="type_etablissements_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $type_etablissements = $em->getRepository('App:Type_etablissements')->findAll();

        return $this->render('type_etablissements/index.html.twig', array(
            'type_etablissements' => $type_etablissements,
        ));
    }


    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="type_etablissements_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadType_etablissementsAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('type_etablissements_upload', array('id' => $media->getId()));
        }


        $type_etablissements[] = new Type_etablissements();
        $media1 =new Media();
        $nom_exel='type_etablissements';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'type d\'établissements'));

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
                $type_etablissement = new Type_etablissements();

                $type_etablissement->setName($objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $type_etablissement->setDescription($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $type_etablissements[$i] = $type_etablissement;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($type_etablissement);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'type_etablissements' => $type_etablissements,
            'form' => $form->createView(),
        ));

    }

    /**
     * Creates a new type_etablissement entity.
     *
     * @Route("/new", name="type_etablissements_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $type_etablissement = new Type_etablissements();
        $form = $this->createForm('App\Form\Type_etablissementsType', $type_etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type_etablissement);
            $em->flush();

            return $this->redirectToRoute('type_etablissements_show', array('id' => $type_etablissement->getId()));
        }

        return $this->render('type_etablissements/new.html.twig', array(
            'type_etablissement' => $type_etablissement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a type_etablissement entity.
     *
     * @Route("/{id}", name="type_etablissements_show")
     * @Method("GET")
     */
    public function showAction(Type_etablissements $type_etablissement)
    {
        $deleteForm = $this->createDeleteForm($type_etablissement);

        return $this->render('type_etablissements/show.html.twig', array(
            'type_etablissement' => $type_etablissement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing type_etablissement entity.
     *
     * @Route("/{id}/edit", name="type_etablissements_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Type_etablissements $type_etablissement)
    {
        $deleteForm = $this->createDeleteForm($type_etablissement);
        $editForm = $this->createForm('App\Form\Type_etablissementsType', $type_etablissement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_etablissements_show', array('id' => $type_etablissement->getId()));
        }

        return $this->render('type_etablissements/edit.html.twig', array(
            'type_etablissement' => $type_etablissement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a type_etablissement entity.
     *
     * @Route("/{id}", name="type_etablissements_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Type_etablissements $type_etablissement)
    {
        $form = $this->createDeleteForm($type_etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($type_etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('type_etablissements_index');
    }

    /**
     * Creates a form to delete a type_etablissement entity.
     *
     * @param Type_etablissements $type_etablissement The type_etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Type_etablissements $type_etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_etablissements_delete', array('id' => $type_etablissement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
