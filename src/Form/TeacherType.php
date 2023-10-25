<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\ClassesRepository;

class TeacherType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['dev'];
        $builder
            ->add('name')
            ->add('firstName')
                 ->add('classes', EntityType::class, ['label' => 'Choisissez une classe :',
                'required'      => true,
                'group_by'      => 'niveau',
                'multiple'      => true,
                'class'         => 'App:Classes',
                'query_builder' => function (ClassesRepository $er) use ($id) {
                    return $er->getClassesPerSchool($id);
    }])           
            ->add('tel')
            ->add('email')
            ->add('sexe', ChoiceType ::class, array(
                'choices' => array(
                    'Masculin' => 'Masculin',
                    'Féminin' => 'Féminin',
                ),
                'preferred_choices' => array('muppets', 'arr'),
            ))
            ->add('dateDeNaissance',DateType::class,[
                'widget' => 'single_text',
                'required'=>false
            ])
            //->add('dateCreate')
            //->add('etablissements')
            ->add('matieres')
            ->add('file', FileType::class, array('label'=>'Photo', 'required' => false ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Teacher'
        ));
                $resolver->setRequired(['dev']);

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_teacher';
    }


}
