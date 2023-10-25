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
use App\Repository\RegionsRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\Form\FormEvents;
use App\Repository\CityRepository;
use App\Repository\SubdivisionRepository;
use App\Entity\Regions;
use App\Entity\Department;
use App\Entity\City;
use App\Entity\Subdivision;
use App\Entity\Country;
use Symfony\Component\Form\FormInterface;

class UserInspType extends AbstractType
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
                ->add('phoneNumber')
                ->add('typeEtablissement')
                ->add('plainPassword',RepeatedType::class,[
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
        'Ministeriel' => "ROLE_PAYS",
        'Regional' => "ROLE_REGION",
        'Departemental' => "ROLE_DEPT",
        'Communal' => "ROLE_ARR",
        
    ],'multiple'=>False,
       'expanded'=>FALSE
])
                ->add('phoneNumber')
                 ->add('country', EntityType::class, array(
                'class'=>'App\Entity\Country',
                'placeholder'=>'selectionnez le pays',
                'mapped'=>false,
                'required'=>false
            ));
        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                /*dump($event->getForm());
                dump($event->getForm()->getData());*/
                $form = $event->getForm();
                $this->addRegionField($form->getParent(), $form->getData());



            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                //dump($data);

                /**
                 *  @var Subdivision $sub
                 *  
                 */ 

                $sub = $data->getZone();
                
                $form = $event->getForm();
                if(!empty($sub)){
                    $city = $sub->getCity();
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
                    dump($data);
                     $this->addRegionField($form, null);
                     $this->addDepartmentField($form, null);
                     $this->addCityField($form , null);
                     $this->addSubdivisionField($form, null);

                     }
                     //$this->addCityField($form, null);

                 
            }
        );
    }

  
    /**
     * Rajoute le champs region au formulaire
     * @param FormInterface $form
     * @param Country $country
     */
    private function addRegionField(FormInterface $form, ? Country $country){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'regions',
            EntityType::class,
            null,
            array(
                'class'=> Regions::class,
                'placeholder'=> $country ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>false,
                'required'=>false,
                'auto_initialize' => false,
                'choices' => $country ? $country->getRegions() : []
            )
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                //dump($event->getForm());
                $form = $event->getForm();
                $this->addDepartmentField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    /**
     * Rajoute le champs department au formulaire
     * @param FormInterface $form
     * @param Regions $regions
     */
    private function addDepartmentField(FormInterface $form, ? Regions $regions){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'departments',
            EntityType::class,
            null,
            array(
                'class'=> Department::class,
                'placeholder'=> $regions ? 'sélectionnez le département' : 'Sélectionnez d\'abord la région',
                'mapped'=>false,
                'required'=>false,
                'auto_initialize' => false,
                'choices' => $regions ? $regions->getDepartments() : []
            )
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                //dump($event->getForm());
                $form = $event->getForm();
                $this->addCityField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    private function addCityField(FormInterface $form, ? Department $departments){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'city',
            EntityType::class,
             null,
            array(
                'class'=> City::class,
                'placeholder'=> $departments ? 'sélectionnez la ville' : 'sélectionnez d\'abord le département',
                'mapped'=>false,
                'required'=>false,
                'auto_initialize' => false,
                'choices' => $departments ? $departments->getCity() : []
            )
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                //dump($event->getForm());
              //dump($event->getForm()->getData());
                $form = $event->getForm();
                $this->addSubdivisionField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    /**
     * Rajoute le champs city au formulaire
     * @param FormInterface $form
     * @param City $city
     */
    private function addSubdivisionField(FormInterface $form, ? City $city){

        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'zone',
            EntityType::class,
             null,
            array(
                'class'=> Subdivision::class,
                'placeholder'=> $city ? 'sélectionnez votre arrondissement' : 'sélectionnez d\'abord la ville',
                'mapped'=>false,
                'required'=>false,
                'auto_initialize' => false,
                'choices' => $city ? $city->getSubdivisions() : []
            )
        );
        

        $form->add($builder->getForm());


    }

    
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
