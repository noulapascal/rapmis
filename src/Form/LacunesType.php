<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Students;
use App\Entity\Classes;
use App\Repository\ClassesRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Repository\StudentsRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LacunesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ets=$options['ets'];

        
        $builder->add('libelle',null,[
            'label'=>'Lacunes'
        ])
                ->add('suggestions')
                ->add('observations',null,[
                    'label'=>'Chapitre ou leçon'
                ] )
 ->add('classes',EntityType::class,[
                    'class'=> Classes::class,
                    'group_by'=>'niveau',
                    'placeholder'=>'selectionnez une classe',
                    'mapped'=>false,
                    'required'=>false,
                    'choices'=>$ets->getClasses()                   
        ,
                    
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
                //dump($data);

                /**
                 *  @var student $student
                 *  
                 */ 

                $student = $data->getStudents()[0];
                $form = $event->getForm();
                if(!empty($student)){
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
;
    }
    
    /**
     * Rajoute le champs student au formulaire
     * @param FormInterface $form
     * @param Classes $classes
     */
    private function addStudentField(FormInterface $form, ? Classes $classes){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'students',
            EntityType::class,
            null,
            array(
                'class'=>Students::class,
                'placeholder'=> $classes ? 'Sélectionnez l\'élève' : 'Sélectionnez d\'abord la classe',
                'mapped'=>false,
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
            'data_class' => 'App\Entity\Lacunes'
        ));
                        $resolver->setRequired(['ets']);

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_lacunes';
    }


}
