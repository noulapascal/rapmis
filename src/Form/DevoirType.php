<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Classes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DevoirType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teacher = $options['teacher'];
        $builder->add('homework')
                ->add('givenOn')
                ->add('doBefore')
                ->add('classe',EntityType::class,[
                    'class'=> Classes::class,
                    'group_by'=>'niveau',
                    'placeholder'=>'selectionnez une classe',
                    'mapped'=>false,
                    'required'=>false,
                    'choices'=> $teacher->getClasses()              
        ,
                    
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Devoir'
        ));
        $resolver->setRequired('teacher');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_devoir';
    }


}
