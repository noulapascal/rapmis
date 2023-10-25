<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Teacher controller.
 *
 * @Route("teacher/{_locale?fr }",locale="fr", requirements={
 * "_locale": "en|fr",
 * "_format": "html|xml",
 * })
 */
class TeacherController extends AbstractController
{
    /**
     * Lists all teacher entities.
     *
     * @Route("/", name="teacher_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$teachers = $em->getRepository('App:Teacher')->findAll();

        $teachers = $em->getRepository('App:Teacher')
            ->findBy(array('etablissements'=>$this->getUser()->getEtablissements()));
        return $this->render('teacher/index.html.twig', array(
            'teachers' => $teachers,
        ));
    }

    /**
     * Creates a new teacher entity.
     *
     * @Route("/new", name="teacher_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request)
    {
        $teacher = new Teacher();
        $teacher->setDateDeCreation(new \DateTime());
        $teacher->setEtablissements($this->getUser()->getEtablissements());
        $form = $this->createForm(TeacherType::class, $teacher, [
            'dev' => $this->getUser()->getEtablissements()
        ]);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
              $file = $form->get('file')->getData();
            if (!empty($file)){           
                $teacher->setFilename($file->getClientOriginalName());    
                $em->persist($teacher);
            $em->flush();
            $name = "file".$teacher->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/teacher";
            $teacher->setFilename($name);
            $file->move($directory, $name);
            }
            
            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('teacher_show', array('id' => $teacher->getId()));
        }

        return $this->render('teacher/new.html.twig', array(
            'teacher' => $teacher,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a teacher entity.
     *
     * @Route("/{id}", name="teacher_show")
     * @Method("GET")
     */
    public function showAction(Teacher $teacher)
    {
        $deleteForm = $this->createDeleteForm($teacher);

        return $this->render('teacher/show.html.twig', array(
            'teacher' => $teacher,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing teacher entity.
     *
     * @Route("/{id}/edit", name="teacher_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Teacher $teacher)
    {
        $deleteForm = $this->createDeleteForm($teacher);
        $editForm = $this->createForm(TeacherType::class, $teacher,  [
            'dev' => $this->getUser()->getEtablissements()
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();
            $file = $editForm['file']->getData();
                        if (!empty($file)){           
                $teacher->setFilename($file->getClientOriginalName());     
            }
            $em->persist($teacher);
            $em->flush();
            if (!empty($file)){   
            $name = "file".$teacher->getId().'.'.$file->guessExtension();
             $directory = __DIR__."/../../public/uploads/media/teacher/";
            $teacher->setFilename($name);
            $file->move($directory, $name);
            $em->persist($teacher);
            $em->flush();

            }
            return $this->redirectToRoute('teacher_show', array('id' => $teacher->getId()));
        }

        return $this->render('teacher/edit.html.twig', array(
            'teacher' => $teacher,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a teacher entity.
     *
     * @Route("/delete/{id}", name="teacher_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, Teacher $teacher)
    {
     //   $form = $this->createDeleteForm($teacher);
       // $form->handleRequest($request);

      //  if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($teacher);
            $em->flush();
       // }

        return $this->redirectToRoute('teacher_index');
    }

    /**
     * Creates a form to delete a teacher entity.
     *
     * @param Teacher $teacher The teacher entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Teacher $teacher)
    {
        $directory = __DIR__."/../../public/uploads/media/teacher";
        $file = $directory.'/'.$teacher->getFilename();
        if(is_file($file)){
                    unlink($file);

        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_delete', array('id' => $teacher->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
