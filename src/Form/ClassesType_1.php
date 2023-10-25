<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\SchoolYear;
use App\Repository\NiveauRepository;


class ClassesType_1 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['type'];
        $builder
            ->add('niveau', null, array(
                'query_builder'=>function (NiveauRepository $dist) use($type) {
                        return $dist->getNiveauPerSchoolType($type);
                },
//                'label'=>'Level',

        ))

                        
                        ->add('name', null, array('label'=>'Number or letter'))
                        ->add('emploiDuTemps',FileType::class ,  ['required' => false]);
            //->add('etablissements');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Classes'
        ));
        $resolver->setRequired(['type']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_classes';
    }


}
