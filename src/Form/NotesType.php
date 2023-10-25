<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Students;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Entity\Classes;
use App\Entity\Notes;
use App\Repository\ClassesRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
class NotesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $ets=$options['ets'];
        $builder
            ->add('nameEvaluation', ChoiceType ::class, array(
                'choices' => array(
                    '1ère sequence' => 'sequence 1',
                    '2eme sequence' => 'sequence 2',
                    '3eme sequence' => 'sequence 3',
                    '4eme sequence' => 'sequence 4',
                    '5eme sequence' => 'sequence 5',
                    '6eme sequence' => 'sequence 6',
                    'Travaux pratique ' => 'TP',
                    'Devoir à domicile ' => 'homework à domicile',
                    'autres ' => 'autre',

                ),
                'preferred_choices' => array('muppets', 'arr'),
            ))
            ->add('teacher', EntityType::class,[
                'class'=> \App\Entity\Teacher::class,
                 'query_builder'=>function (TeacherRepository $dist) use($ets) {
                    
               return    $dist->getTeacherPerSchool($ets);
                   
        }
                
            ])
            ->add('matieres')
            ->add('module')
            ->add('valeur')
            ->add('coeff')
            ->add('commentaire')
                ->add('classes',EntityType::class,[
                    'class'=> Classes::class,
                    'group_by'=>'niveau',
                    'placeholder'=>'selectionnez une classe',
                    'mapped'=>false,
                    'required'=>false,
                    'query_builder'=>function (ClassesRepository $dist) use($ets) {
                    
               return    $dist->getClassesPerSchool($ets);
                   
        },
                    
                ]);
                
                $builder->get('classes')->addEventListener
                (
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                /*dump($event->getForm());
                dump($event->getForm()->getData());*/
                $form = $event->getForm();
                $this->addStudentField($form->getParent(), $form->getData());



            }
        );
          $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                dump($data);

                /**
                 *  @var Notes $student
                 *  
                 */ 

             //   $student = $data->getStudents();
                $form = $event->getForm();
                if(!empty($student))
                {
                    $classes = $student->getClasses();
                    $this->addStudentField($form, $classes);
                    //on préremplir ce qu'on a trouvé dans la base de donnée
                    $form->get('classes')->setData($$classes);
                    $form->get('student')->setData($students);
                }
                 else{
                    
                     $this->addStudentField($form, null);

                     }
                     //$this->addCityField($form, null);

                 
            }
            );
    }
    
    private function addStudentField(FormInterface $form, ? Classes $classes){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'students',
            EntityType::class,
            null,
            array(
                'class'=>'App\Entity\Students',
                'placeholder'=> $classes ? 'Sélectionnez l\'élève' : 'Sélectionnez d\'abord la classe',
                'mapped'=>true,
                'required'=>false,
                'auto_initialize' => false,
                'choices' => $classes ? $classes->getStudents() : []
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
            'data_class' => 'App\Entity\Notes'
        ));
        $resolver->setRequired('ets');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_notes';
    }


}
