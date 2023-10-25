<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\ClassesRepository;
use App\Entity\Modules;
use App\Entity\Classes;


class ModulesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['dev'];
        $builder
            ->add('classes', EntityType::class, ['label' => 'Choisissez une classe :',
                'required'      => true,
                'class'         => 'App:Classes',
                'query_builder' => function (ClassesRepository $er) use ($id) {
                    return $er->getClassesPerSchool($id);
                },
                'attr'   => ['class' => 'form-control'] ])
            ->add('name')
            ->add('description')
            ->add('coeff')
            ->add('matieres');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
       /* $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Modules'
        ));*/
        $resolver->setRequired(['dev']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_modules';
    }


}
