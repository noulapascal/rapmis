<?php

namespace App\Form;

use App\Entity\Distinction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\ClassesRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class StudentsType extends AbstractType
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
                'group_by'      => 'niveau',
                'class'         => 'App:Classes',
                'query_builder' => function (ClassesRepository $er) use ($id) {
                    return $er->getClassesPerSchool($id);
                },
                'attr'   => ['class' => 'form-control'] ])
            ->add('name')
            ->add('firstName')
            ->add('sexe', ChoiceType ::class, array(
                'choices' => array(
                    'Masculin' => 'Masculin',
                    utf8_decode('Féminin') => 'Féminin',
                ),
                'preferred_choices' => array('muppets', 'arr'),
            ))
            ->add('lieuDeNaissance')
            ->add('dateDeNaissance', DateType::class, array('label' => 'Année de Naissance', 'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Selectionner ou entrer la date de naissance',))
            ->add('cycle', ChoiceType ::class, array(
                'choices' => array(
                    'Premier cycle' => 'Premier cycle',
                    'Second cycle' => 'Second cycle',
                ),
                'preferred_choices' => array('muppets', 'arr'),
            ))
            ->add('responsable')
            ->add('telResponsable',null,[
                'required'=>true
            ])
            ->add('emailResponsable', EmailType::class,[
                'required'=>true
            ])
            ->add('pere')
           /* ->add('distinctions',EntityType::class,array(
                'class'=>'App:Distinction',
                'placeholder'=>'distinction',
                'choice_label' => 'name',
                'required'=>'false',
                'expanded'=>'true',
                'multiple'=>'true'
            ))*/
            ->add('mere')
            ->add('tuteur')
            ->add('telPere')
            ->add('telMere')
            ->add('telTuteur')
            ->add('emailPere')
            ->add('emailMere')
            ->add('emailTuteur')
            ->add('profPere')
            ->add('profMere')
            ->add('profTuteur')
            ->add('residenceParents')
            ->add('proche1')
            ->add('telProche1')
            ->add('proche2')
            ->add('telProche2')
            ->add('proche3')
            ->add('telProche3')
            ->add('nouveau')
            ->add('redoublant')
            ->add('etudeDossier')
            ->add('serie')
            ->add('moyPassageClasse')
            ->add('rang')
            ->add('lastSchool')
            ->add('nameChefLastSchool')
            ->add('dateCreate', DateTimeType::class, array('label' => 'Date d\'inscription', 'required' => false))
            ->add('groupeSanguin')
            ->add('pathogieParticuliere')
            ->add('allergieAlimentaire')
            ->add('allergieMedicamenteuse')
            ->add('dispense')
            ->add('medecinFamiliale')
            ->add('telMedecinFamiliale')
            ->add('assuranceFamille')
            ->add('hopitalAgree')
            ->add('rhesus')
            ->add('inaptitude')
            ->add('justificationInaptitude', FileType::class,[
                "required"=>false
            ])
            ->add('file', FileType::class, array('label' => 'Photo', 'required' => false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'App\Entity\Students'
        ));*/

        $resolver->setRequired(['dev']);
       
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_students';
    }


}
