<?php

namespace App\Form;

use Symfony\Component\OptionResolver\OptionsResolverInterface;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Teacher;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Regions;
use App\Entity\Department;
use App\Entity\City;
use Symfony\Component\Form\FormInterface;



class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('username')
                ->add('locale', ChoiceType::class,[
                'choices'=>[
                    'Français'=>"fr",
                    'English'=>'en'
                ],
                'label'=>'Langue'
            ])

                ->add('email')
                ->add('password',RepeatedType::class,[
                    'type'=>PasswordType::class, 
                    'invalid_message' => 'The password fields must match.',
    'options' => ['attr' => ['class' => 'password-field']],
    'required' => true,
    'first_options'  => ['label' => 'Password'],
    'second_options' => ['label' => 'Repeat Password']
                ])
                ->add('photoDeProfil',FileType::class,array('label' => 'Photo', 'required' => false))
                 ->add('typeDeCompte',ChoiceType::class, [
    'choices'  => [
        'Super Administrateur' => "ROLE_SUPER_ADMIN",
        'Administrateur (Ecole)' => "ROLE_ADMIN",
        
        
    ],'multiple'=>False,
       'expanded'=>FALSE
])
                ->add('phoneNumber')
                
                ->add('etablissements', EntityType::class,[
                    'class'=>'App\Entity\Etablissements',
                    'group_by'=>'city'
                ]);
    }
      /*           ->add('country', EntityType::class, array(
                'class'=>'App\Entity\Country',
                'placeholder'=>'selectionnez le pays',
                'mapped'=>false,
                'required'=>false
            ));
    
        
         $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                /*dump($event->getForm());
                dump($event->getForm()->getData());
                $form = $event->getForm();
                dump($form->getParent());
                $this->addRegionField($form->getParent(), $form->getData());



            }
        );

                $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                //dump($data);

                /* @var $city City 
                $form = $event->getForm();
                if(!empty($form->has('city'))){
                    $city = $form->get('city');
                }else{
                    $city=null;
                }
                    ;
                
                if(!empty($city)){
                    $departments = $city->getDepartments();
                    $regions = $departments->getRegions();
                    $country = $regions->getCountry();
                    $this->addRegionField($form, $country);
                    $this->addDepartmentField($form, $regions);
                    $this->addCityField($form, $departments);
                    //on préremplir ce qu'on a trouvé dans la base de donnée
                    $form->get('country')->setData($country);
                    $form->get('regions')->setData($regions);
                    $form->get('departments')->setData($departments);
                    $form->get('city')->setData($city);
                }
                 else{
                     $this->addRegionField($form, null);
                     $this->addDepartmentField($form, null);
                   /*  if(!empty($departments)){
                                              $this->addCityField($form,$departments);

                     }
                     else{
                                              $this->addCityField($form, null);

                     }
                     $this->addCityField($form, null);

                 }
            }
        );
    }
    
    
    
    /**
     * Rajoute le champs region au formulaire
     * @param FormInterface $form
     * @param Country $country
     */
    
    
    
    /**
     * {@inheritdoc}
     */
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
                'cascade_validation' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_user';
    }
 
    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
       $resolver->setDefaults(array(
           'data_class' => User::class,
           'cascade_validation' => true,
       ));
}
   

}
