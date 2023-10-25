<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Subdivision;
use App\Entity\Regions;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Entity\Country;
use App\Entity\Department;
use App\Entity\City;
use Symfony\Component\Form\FormInterface;
class SearchSubSelectType_1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder->add('regions', EntityType::class, array(
                'class'=> Regions::class,
                'placeholder'=>'selectionnez la région',
                'mapped'=>false,
                'required'=>false
            ));

        $builder->get('regions')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                /*dump($event->getForm());
                dump($event->getForm()->getData());*/
                $form = $event->getForm();

                $data = $event->getData();
                dump($data);

                $this->addDepartmentField($form->getParent(), $form->getData());



            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                dump($data);

                /**
                 *  @var Subdivision $sub
                 *  
                 */ 

                
                $sub = !empty($data)?$data->getSubdivision():null;
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
                    //$form->get('country')->setData($country);
                    $form->get('regions')->setData($regions);
                    $form->get('departments')->setData($departments);
                    $form->get('city')->setData($city);
                }
                else{
                     
                    // $this->addRegionField($form, null);
                     $this->addDepartmentField($form, null);
                     $this->addCityField($form , null);
                      $this->addSubdivisionField($form, null);

                     }
                     //$this->addCityField($form, null);

                 
            }
        );

         
        ;
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
                'group_by'=>'country',
                'required'=>false,
                'auto_initialize' => false,
              //  'choices' => !empty($country)? $country->getRegions() : []
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
                'mapped'=>true,
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
            'subdivision',
            EntityType::class,
             null,
            array(
                'class'=> Subdivision::class,
                'placeholder'=> $city ? 'sélectionnez votre arrondissement' : 'sélectionnez d\'abord la ville',
                'mapped'=>true,
                'required'=>false,
                'auto_initialize' => false,
                'choices' =>!empty($city)? $city->getSubdivisions() : []
            )
        );
        

        $form->add($builder->getForm());


    }

    
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
