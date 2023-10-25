<?php

namespace App\Form;

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
use App\Entity\Regions;
use App\Entity\Department;
use App\Entity\City;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class RegionSelType extends AbstractType
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
              /*->add('regions', EntityType::class, array(
                'class'=>'App\Entity\Regions',
                'placeholder'=>'selectionnez la région',
                'mapped'=>false,
                'required'=>true
            ));*/;
        $builder->get('country')-> addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                //dump($event->getForm());
                //dump($event->getForm()->getData());
                $form = $event->getForm();
                $country=$form->get('country')->getData();         //   if(!empty($country))
                
                        $builder = $form->getParent()->getConfig()->getFormFactory()->createNamedBuilder('regions',
            EntityType::class,null,
            
            array(
                'class'=>'App\Entity\Regions',
                'placeholder'=> $country ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>false,
                'required'=>false, 
                'auto_initialize' => false,
                'choices' =>$country->getRegions()
            ));


    });
    
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
                'class'=>'App\Entity\Regions',
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
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
 
        $resolver->setDefaults(array(
     // 'compound' => true,
            'data_class' => City::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_etablissements';
    }


}
