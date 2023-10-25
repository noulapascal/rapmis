<?php

namespace App\Controller;

use App\Entity\Addresses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Entity\Media;

/**
 * Address controller.
 *
 * @Route("addresses")
 */
class AddressesController extends AbstractController
{
    /**
     * Lists all address entities.
     *
     * @Route("/", name="addresses_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('App:Addresses')->findAll();

       return $this->render('addresses/index.html.twig', array(
            'addresses' => $addresses,
        ));

       /*return $this->render('sandboxBundle:Default:template.html.twig', array(
            'addresses' => $addresses,
            'title'=>'Mon premier bulletin'
        ));*/
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/upload", name="addresses_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadAdressesAction(Request $request){

        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('addresses_upload', array('id' => $media->getId()));
        }
        //debut adresses
        $addresses[] = new Addresses();
        $media1 =new Media();
        $nom_exel='addresses';
        $em = $this->getDoctrine()->getManager();
        $media1 = $em->getRepository('App:Media')->findOneBy(array('name' => 'addresses'));

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
                $addresse = new Addresses();

                $addresse->setEmail(  $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue() ) ;
                $addresse->setBP($objPHPExcel->getActiveSheet()->getCell("B$i")->getValue());
                $addresse->setTel($objPHPExcel->getActiveSheet()->getCell("C$i")->getValue());
                $addresse->setLongitude($objPHPExcel->getActiveSheet()->getCell("D$i")->getValue());
                $addresse->setLatitude($objPHPExcel->getActiveSheet()->getCell("E$i")->getValue());
                $addresse->setFax($objPHPExcel->getActiveSheet()->getCell("F$i")->getValue());

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

                $addresses[$i] = $addresse;
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->
                persist($addresse);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                $i++;
            }
            $em->remove($media1);
            $em->flush();

        }


        return $this->render('media/new.html.twig', array(
            'media' => $media,
            'addresses' => $addresses,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new address entity.
     *
     * @Route("/new", name="addresses_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $address = new Addresses();
        $form = $this->createForm('App\Form\AddressesType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('addresses_show', array('id' => $address->getId()));
        }

        return $this->render('addresses/new.html.twig', array(
            'address' => $address,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a address entity.
     *
     * @Route("/{id}", name="addresses_show")
     * @Method("GET")
     */
    public function showAction(Addresses $address)
    {
        $deleteForm = $this->createDeleteForm($address);

        return $this->render('addresses/show.html.twig', array(
            'address' => $address,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing address entity.
     *
     * @Route("/{id}/edit", name="addresses_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Addresses $address)
    {
        $deleteForm = $this->createDeleteForm($address);
        $editForm = $this->createForm('App\Form\AddressesType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('addresses_show', array('id' => $address->getId()));
        }

        return $this->render('addresses/edit.html.twig', array(
            'address' => $address,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a address entity.
     *
     * @Route("/{id}", name="addresses_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Addresses $address)
    {
        $form = $this->createDeleteForm($address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();
        }

        return $this->redirectToRoute('addresses_index');
    }

    /**
     * Creates a form to delete a address entity.
     *
     * @param Addresses $address The address entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Addresses $address)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('addresses_delete', array('id' => $address->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
