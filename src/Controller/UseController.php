<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType_1;
use App\Form\UserTeacherType;
use App\Form\CountrySelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\UserType;
use App\Form\UserType_2;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Country;
use App\Form\UserInspType;
use App\Form\UserDepType;
use App\Form\UserRegType;
use App\Form\UserMinType;
use App\Form\UserSeducType;
use App\Form\UserSeducDeptType;
use Symfony\Component\HttpFoundation\Request;

/**
 * use controller.
 *
 * @Route("use")
 */

class UseController extends AbstractController
{

    /**
     * @Route("/teacher", name="user_teacher")
     * @Route("/update", name="user_update")
     * @Security("is_granted('ROLE_ADMIN')")
     */
public function newUserAction(Request $request,UserPasswordEncoderInterface $passwordEncoder){
    $user=new User();
        $form= $this->createForm(UserTeacherType::class,$user,[
            'dev'=>$this->getUser()->getEtablissements()

        ]);
                $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $i=0;
            foreach ($user->getTypeDeCompte() as $key => $value) {
                         $user->setRoles([$user->getTypeDeCompte()[$i]]);
                         $i++;
   
            }
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setUsername($form->get('username')->getData());
            $user->setPhoneNumber($user->getTeacher()->getTel());
            if($user->getTeacher()->getEmail()){
                          $user->setEmail($user->getTeacher()->getEmail());
                          
            }
            else
            {
            //    $user->setEmail("blank");
                
            }
                $user->setPhotoDeProfil($user->getTeacher()->getFile());
                $user->setEnabled('1');
                $user->setEtablissements($this->getUser()->getEtablissements());
                $em->persist($user);
                $em->flush();
                if (empty($user->getEmail()) or $user->getEmail() == ''){
                                    $user->setEmail("blank".$user->getId());
                }
                
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('fos_user_registration_confirmed');
                 
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
            
        
    
}
    /**
     * @Route("/staff", name="user_staff")
     * @Route("/update", name="user_update")
     * @Security("is_granted('ROLE_ADMIN')")
     */
public function newStaffAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
    $user=new User();
        $form= $this->createForm(UserType_2::class,$user,[
            'dev'=>$this->getUser()->getEtablissements()

        ]);
                $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            
            if($user->getStaff()->getMail()){
                          $user->setEmail($user->getStaff()->getMail());
                          
            }
            else
            {
                $user->setEmail("notdefined".$user->getUsername());
                
            }
            
            
            $user->setRoles([$user->getTypeDeCompte()]);
          //  $user->setUsername($user->getStaff()->getName());
          //  $user->setPhoneNumber($user->getStaff()->getTel());
            $user->setEnabled('1');
            $user->setEtablissements($this->getUser()->getEtablissements());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
            
        
    
}
    /**
     * @Route("/", name="super_user_new")
     * @security("is_granted('ROLE_SUPER_ADMIN')")
     */
public function superNewAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
    $user=new User();
        $form= $this->createForm(UserType::class,$user,[
         //   'dev'=>$this->getUser()->getEtablissements()

        ]);
                $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('password')->getData()
                )   
            );
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setEnabled('1');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
            
        
    
}


    /**
     * @Route("/inspect_sel", name="user_inspect")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function inspectSel(Request $request){
                $form= $this->createForm(CountrySelType::class);
                        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            $country= $this->getDoctrine()->getRepository('App:Country')->find($form['country']->getData());
            return $this->redirectToRoute('inspect_create', [
                'country'=>$country->getId()
            ]);
        }
        
                    return $this->render('user/countrySel.html.twig',[
                        'form'=>$form->createView()
                    ]);

    }

    /**
     * @Route("/dep_sel", name="user_dep")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function deptSel(Request $request){
                $form= $this->createForm(CountrySelType::class);
                        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            $country= $this->getDoctrine()->getRepository('App:Country')->find($form['country']->getData());
            return $this->redirectToRoute('dept_create', [
                'country'=>$country->getId()
            ]);
        }
        
                    return $this->render('user/countrySel.html.twig',[
                        'form'=>$form->createView()
                    ]);

    }

    /**
     * @Route("/reg_sel", name="user_reg")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function regSel(Request $request){
                $form= $this->createForm(CountrySelType::class);
                        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            $country= $this->getDoctrine()->getRepository('App:Country')->find($form['country']->getData());
            return $this->redirectToRoute('reg_create', [
                'country'=>$country->getId()
            ]);
        }
        
                    return $this->render('user/countrySel.html.twig',[
                        'form'=>$form->createView()
                    ]);

    }

    /**
     * @Route("/min_sel", name="user_min")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function minSel(Request $request){
                $form= $this->createForm(CountrySelType::class);
                        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            $country= $this->getDoctrine()->getRepository('App:Country')->find($form['country']->getData());
            return $this->redirectToRoute('min_create', [
                'country'=>$country->getId()
            ]);
        }
        
                    return $this->render('user/CountrySel.html.twig',[
                        'form'=>$form->createView()
                    ]);

    }

    /**
     * @Route("/inspect_create/{country?}" , name="inspect_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function inspectCreation(?Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserInspType::class,$user,[
            
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            
            $user->setZone($form->get('zone')->getData()->getId());
            $user->setEnabled('1');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }

    /**
     * @Route("/dept_create/{country}" , name="dept_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function deptCreation(Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserDepType::class,$user,[
            'dev'=>$country->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setEnabled('1');
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setZone($form->get('zone')->getData()->getId());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }

    /**
     * @Route("/reg_create/{country}" , name="reg_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function regCreation(Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserRegType::class,$user,[
            'dev'=>$country->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setEnabled('1');
            $user->setZone($form->get('zone')->getData()->getId());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }


    /**
     * @Route("/reg_seduc_create/{country}" , name="reg_seduc_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function regSeducCreation(Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserSeducType::class,$user,[
            'dev'=>$country->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setEnabled('1');
            $user->setZone($form->get('zone')->getData()->getId());
            $user->setObedience($form->get('obedience')->getData()->getId());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }


    /**
     * @Route("/dep_seduc_create/{country}" , name="dep_seduc_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function depSeducCreation(Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserSeducDeptType::class,$user,[
            'dev'=>$country->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setEnabled('1');
            $user->setZone($form->get('zone')->getData()->getId());
            $user->setO($form->get('zone')->getData()->getId());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }

    /**
     * @Route("/min_create/{country?}" , name="min_create")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function MinCreation(?Country $country, Request $request, UserPasswordEncoderInterface $passwordEncoder){

    $user=new User();
        $form= $this->createForm(UserMinType::class,$user,[
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getTypeDeCompte()]);
            $user->setEnabled('1');
            $user->setPassword($passwordEncoder->encodePassword(
                    $user,$form->get('plainPassword')->getData()
                )
            );
            $user->setZone($form->get('zone')->getData()->getId());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('fos_user_registration_confirmed');
        }
        return $this->render('user/index1.html.twig',array(
            'form'=>$form->createView()));
        }
    
    
}
