<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Department;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Subdivision;
use App\Entity\Regions;
use App\Entity\City;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
class SearchDeptSelectType_1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departments', EntityType::class, array(
                'class'=> Department::class,
                'placeholder'=>'selectionnez le Departement',
                'group_by'=>'regions',
                'required'=>true,
              //  'choices' => $region ? $$region->getDepartments() : []

            ))
        ;
        
        $builder->get('departments')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                /*dump($event->getForm());
                dump($event->getForm()->getData());*/
                $form = $event->getForm();

                $data = $event->getData();
                //dump($data);

                $this->addDepartmentField($form->getParent(), $form->getData());



            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
               // dump($data);

                /**
                 *  @var Subdivision $sub
                 *  
                 */ 

                
                $sub = !empty($data)?$data->getSubdivision():null;
                $form = $event->getForm();
                if(!empty($sub)){
                    $city = $sub->getCity();
                    $departments = $city->getDepartments();
                    $this->addCityField($form, $departments);
                    //on préremplir ce qu'on a trouvé dans la base de donnée
                    //$form->get('country')->setData($country);
                    $form->get('departments')->setData($departments);
                    $form->get('city')->setData($city);
                }
                else{
                     
                    // $this->addRegionField($form, null);
                      $this->addCityField($form , null);
                      $this->addSubdivisionField($form, null);

                     }
                     //$this->addCityField($form, null);

                 
            }
        );

         
        ;
    
    
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
