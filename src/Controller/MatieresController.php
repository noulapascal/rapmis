<?php

namespace App\Controller;

use App\Entity\Matieres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Addresses;
use App\Entity\Media;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPExcel_IOFactory;

/**
 * Matiere controller.
 *
 * @Route("matieres")
 */
class MatieresController extends AbstractController
{
    /**
     * Lists all matiere entities.
     *
     * @Route("/", name="matieres_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matieres = $em->getRepository('App:Matieres')->findAll();

        return $this->render('matieres/index.html.twig', array(
            'matieres' => $matieres,
        ));
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="matieres_upload")
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
            return $this->redirectToRoute('matieres_upload', array('id' => $media->getId()));
        }


        $matieres[] = new Matieres();
        $media1 =new Media();
        $nom_exel='matieres';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'matieres'));

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
                $matiere = new Matieres();

                $matiere->setName(  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $matiere->setIntitule($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $matieres[$i] = $matiere;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($matiere);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'matieres' => $matieres,
            'form' => $form->createView(),
        ));

    }


    /**
     * Creates a new matiere entity.
     *
     * @Route("/new", name="matieres_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $matiere = new Matieres();
        $form = $this->createForm('App\Form\MatieresType', $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('matieres_show', array('id' => $matiere->getId()));
        }

        return $this->render('matieres/new.html.twig', array(
            'matiere' => $matiere,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a matiere entity.
     *
     * @Route("/{id}", name="matieres_show")
     * @Method("GET")
     */
    public function showAction(Matieres $matiere)
    {
        $deleteForm = $this->createDeleteForm($matiere);

        return $this->render('matieres/show.html.twig', array(
            'matiere' => $matiere,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing matiere entity.
     *
     * @Route("/{id}/edit", name="matieres_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Matieres $matiere)
    {
        $deleteForm = $this->createDeleteForm($matiere);
        $editForm = $this->createForm('App\Form\MatieresType', $matiere);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matieres_show', array('id' => $matiere->getId()));
        }

        return $this->render('matieres/edit.html.twig', array(
            'matiere' => $matiere,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a matiere entity.
     *
     * @Route("/{id}", name="matieres_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Matieres $matiere)
    {
        $form = $this->createDeleteForm($matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matiere);
            $em->flush();
        }

        return $this->redirectToRoute('matieres_index');
    }

    /**
     * Creates a form to delete a matiere entity.
     *
     * @param Matieres $matiere The matiere entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Matieres $matiere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matieres_delete', array('id' => $matiere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
