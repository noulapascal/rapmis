<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Subdivision;
use App\Form\SubdivisionType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\City;
use App\Entity\Media;
    /**
     * @Route("subdivision")
     */

class SubdivisionController extends AbstractController
{
    
    
    /**
     * Lists all subdivision entities.
     *
     * @Route("/", name="subdivision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subdivision = $em->getRepository('App:Subdivision')->findAll();

        return $this->render('subdivision/index.html.twig', array(
            'cities' => $subdivision,
        ));
    }
    
    
    
    /**
     * Creates a new subdivision entity.
     *
     * @Route("/new", name="subdivision_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $arr = new Subdivision();
        $form = $this->createForm(SubdivisionType::class, $arr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($arr);
            $em->flush();

            return $this->redirectToRoute('subdivision_show', array('id' => $arr->getId()));
        }

        return $this->render('subdivision/new.html.twig', array(
            'city' => $arr,
            'form' => $form->createView(),
        ));
    }
    
    
    /**
     * Finds and displays a subdivision entity.
     *
     * @Route("/show/{id}", name="subdivision_show")
     * @Method("GET")
     */
    public function showAction(Subdivision $subdivision)
    {
        $deleteForm = $this->createDeleteForm($subdivision);

        return $this->render('subdivision/show.html.twig', array(
            'city' => $subdivision,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing city entity.
     *
     * @Route("/upload", name="subdivision_upload")
     * @Method({"GET", "POST"})
     */
    
    
    
     public function uploadSubdivisionAction(Request $request) 
            {
        $media = new Media();
        $form = $this->createForm('App\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file= $form['file']->getData();
             if (!empty($file)){           
                $media->setFilename($file->getClientOriginalName());     
            }
 
            $name = "file".$media->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/";
            $media->setFilename($name);
            $file->move($directory, $name);
            $em->persist($media);
            $em->flush();

            
            
            $em->persist($media);
            $em->flush();
            
            
            
            
            $mime=mime_content_type( __DIR__.'/../../public/uploads/media/'.''.$media->getFilename());
            if(strpos($media->getFilename(), '.csv') or strpos($media->getFilename(), '.CSV') ){
            	return $this->redirectToRoute('sub_csv_upload', array('id' => $media->getId()));
	
        }else
        
        {
        	return $this->redirectToRoute('sub_csv_upload', array('id' => $media->getId()));

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
     * @Route("/upload_csv/{id}", name="sub_csv_upload")
     * @Method({"GET", "POST"})
     */
    
    public function upload(Media $id) {
        $media1 = $id;
           if($media1->getFilename()){
         //   require_once __DIR__.'/../../../vendor/autoload.php';
          //  require_once __DIR__.'/../../../web/uploads/media/'.''.$media1->getFilename();
            if (($handle = fopen(__DIR__.'/../../public/uploads/media/'.''.$media1->getFilename(), "r")) !== FALSE) {
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
                        $subdivision = new Subdivision();
                        $j = 0;
                        
                       $donnees = array_combine($enTetes, $data);
                       var_dump($donnees);
                        foreach ($enTetes as $key => $value) {
                            if(property_exists($subdivision,lcfirst($value))){
                                
                                    if (lcfirst($value) == 'city')
                                    {
                                        $city = $this->getDoctrine()->getManager()->getRepository("App:City")->findOneBy(array( 'name' => $donnees[lcfirst($value)],
                                            ));
                                        if (!empty($city))
                                        {
                                    $method = 'set'.ucfirst($value);
                                    if(method_exists($subdivision , $method))
                                    {
                                        $subdivision->$method($city);
                                    }
                                  }
                                  else
                                  {
                                    $department = $this->getDoctrine()->getManager()->getRepository('App:Department')->findOneBy([
                                            'name'=>$donnees['department']
                                        ]);  
                                    
                                      $method = 'set'.ucfirst($value);
                                      $city = new City();
                                        $city->setName(strval(utf8_decode($donnees['name'])));
                                        $city->setDepartments($department);
                                        $em1->persist($city);
                                        $em1->flush();    
                                        $method = 'set'.ucfirst($value);
                                        
                                         if(method_exists($subdivision , $method))
                                    {
                                        $subdivision->$method($city);
                                    }
                                  
                                            
                                    }
                                    }
                                    
                                
                                    
                                    
                                else
                                {
                                    $sub = $this->getDoctrine()->getManager()->getRepository('App:Subdivision')->findOneBy([
                                            "name"=> utf8_encode($donnees['name'])
                                        ]);
                                    if(empty($sub)){
                                        
                                $method = 'set'.ucfirst($value);
                                if(method_exists(   $subdivision , $method))
                                $subdivision->$method(strval(utf8_decode($data[$j])));  
                                    }
                               
                                }
                                }
                                
                                 
                            
                            $j++;
                            }
                            
                            
               if(!(empty($subdivision->getName())))
               {
                   $em1->persist($subdivision); 
                   $em1->flush();}
                   
               }else 
               {
                   $em1->flush();
               }
;
                        
                     
                     
                                                 
        $i++;  }
            
                
                }
                
                
                // $em->remove($media1);
           }

  
    fclose($handle);
    return $this->render('base.html.twig');
    }  
   
    
    
    
    
    /**
     * Displays a form to edit an existing city entity.
     *
     * @Route("/{id}/edit", name="subdivision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subdivision $subdivision)
    {
        $deleteForm = $this->createDeleteForm($subdivision);
        $editForm = $this->createForm('App\Form\SubdivisionType', $subdivision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subdivision_show', array('id' => $subdivision->getId()));
        }

        return $this->render('subdivision/edit.html.twig', array(
            'city' => $subdivision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a subdivision entity.
     *
     * @Route("/{id}", name="subdivision_delete")
     * @Method("DELETE")
     */
    
    
      public function deleteAction(Request $request, Subdivision $subdivision)
    {
       /* $form = $this->createDeleteForm($student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
           // $classe = $subdivision->getClasses()->getName();
            //$ets = $subdivision->getClasses()->getNiveau();
            $em->remove($subdivision);
            $em->flush();
//        }

        return $this->redirectToRoute('subdivision_index',[
           // 'flo'=>$classe,
            //'dev'=>$ets
        ]);
    }
    
    /**
     * Creates a form to delete a city entity.
     *
     * @param City $city The city entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subdivision $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subdivision_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    
}
