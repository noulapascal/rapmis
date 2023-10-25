<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use App\Entity\Department;
use App\Entity\Country;
use App\Entity\Regions;

class RegSelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('country', EntityType::class, array(
                'class'=>'App\Entity\Country',
                'placeholder'=>'selectionnez le pays',
                'mapped'=>false,
                'required'=>true
            ))
        ->get('country')-> addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                //dump($event->getForm());
                //dump($event->getForm()->getData());
                $form = $event->getForm();
                       //   if(!empty($country))
/*
                $builder = $form->getParent()->getConfig()->getFormFactory()->createNamedBuilder('regions',
            EntityType::class,null,
            
            array(
                'class'=>'App\Entity\Regions',
                'placeholder'=> $country ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>true,
                'required'=>false, 
                'auto_initialize' => false,
                'choices' =>$country->getRegions()
            ));
*/
                $country = $form->getData();

                $builder = $form->getParent();
              //  $regions = $event->getForm()->getParent()->get('regions')->getData();
                $this->AddRegionField($builder, $country);
            }
            );
            
        
    
        
    }
    
    private function addRegionField(FormInterface $form, ?Country $country) {
              $builder = $form->getConfig()->getFormFactory();
               $dept = $builder->createNamedBuilder('regions', EntityType::class, '',[
                    'class'=>'App\Entity\Regions',
                'placeholder'=>  $country ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>false,
                'required'=>false, 
                'auto_initialize' => false,
                'choices' => $country->getRegions() 
                ]);
                $dept->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event){
                    $form = $event->getForm();
 
                                    
                                $this->AddDeptField($form->getParent(), $form->getData());
 
                }
                       );
                       
                ;
                
                               
                    $form->add($dept->getForm()); 
        
        
    }
    
    private function AddDeptField(FormInterface $form,? Regions $regions) {
        
                $builder = $form->getConfig()->getFormFactory();
               $dept = $builder->createNamedBuilder('department', EntityType::class, '',[
                    'class'=>'App\Entity\Department',
                'placeholder'=>  $regions ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>false,
                'required'=>false, 
                'auto_initialize' => false,
                'choices' =>$regions ? $regions->getDepartments() : []
                ]);
                $dept->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event){
                    
                }
                       );
                ;
                    $form->add($dept->getForm()); 
        
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\RegSel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_regsel';
    }


}
