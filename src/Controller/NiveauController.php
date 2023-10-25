<?php

namespace App\Controller;

use App\Entity\Matieres;
use App\Entity\Niveau;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use App\Entity\City;
use App\Entity\Department;
use App\Entity\Country;
use App\Entity\Regions;
use App\Entity\Addresses;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;

/**
 * Niveau controller.
 *
 * @Route("niveau")
 */
class NiveauController extends AbstractController
{
    /**
     * Lists all niveau entities.
     *
     * @Route("/", name="niveau_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $niveaux = $em->getRepository('App:Niveau')->findAll();

        return $this->render('niveau/index.html.twig', array(
            'niveaux' => $niveaux,
        ));
    }


    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="niveau_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadNiveauAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('niveau_upload', array('id' => $media->getId()));
        }


        $niveaus[] = new Niveau();
        $media1 =new Media();
        $nom_exel='niveau';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'niveau'));

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
                $niveau = new Niveau();

                $matiere->setName(  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $matiere->setIntitule($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());
                $em1 = $this->getDoctrine()->getManager();
                $mat = $em1->getRepository('App:Matieres')->findOneBy(array(
                    'name' => $matiere->getName()));
                $niveau->setMatieres($mat);
                $niveau->setName($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue());
                $niveau->setDescription($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue());

                //inset $column_A_Value value in DB query here
                $name='';
                $name=$objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();


                $entityManager = $this->getDoctrine()->getManager();

                $niveaus[$i] = $niveau;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($niveau);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }
        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'niveaus' => $niveaus,
            'form' => $form->createView(),
        ));

    }


    /**
     * Creates a new niveau entity.
     *
     * @Route("/new", name="niveau_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $niveau = new Niveau();
        $form = $this->createForm('App\Form\NiveauType', $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($niveau);
            $em->flush();

            return $this->redirectToRoute('niveau_show', array('id' => $niveau->getId()));
        }

        return $this->render('niveau/new.html.twig', array(
            'niveau' => $niveau,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a niveau entity.
     *
     * @Route("/{id}", name="niveau_show")
     * @Method("GET")
     */
    public function showAction(Niveau $niveau)
    {
        $deleteForm = $this->createDeleteForm($niveau);

        return $this->render('niveau/show.html.twig', array(
            'niveau' => $niveau,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing niveau entity.
     *
     * @Route("/{id}/edit", name="niveau_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Niveau $niveau)
    {
        $deleteForm = $this->createDeleteForm($niveau);
        $editForm = $this->createForm('App\Form\NiveauType', $niveau);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('niveau_show', array('id' => $niveau->getId()));
        }

        return $this->render('niveau/edit.html.twig', array(
            'niveau' => $niveau,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a niveau entity.
     *
     * @Route("/{id}", name="niveau_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Niveau $niveau)
    {
        $form = $this->createDeleteForm($niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($niveau);
            $em->flush();
        }

        return $this->redirectToRoute('niveau_index');
    }

    /**
     * Creates a form to delete a niveau entity.
     *
     * @param Niveau $niveau The niveau entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Niveau $niveau)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('niveau_delete', array('id' => $niveau->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
