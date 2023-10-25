<?php

namespace App\Form;

use App\Entity\Matieres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Classes;
use App\Repository\ClassesRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\StudentsRepository;
use App\Entity\Students;
use Symfony\Contracts\Translation\TranslatorInterface;
class Facteurs_disciplinairesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
                $ets=$options['ets'];
                $translator=$options['translator'];
        $builder
                
    ->add('motif', ChoiceType ::class, array(
        
                'choices' => array(
                    $translator->trans('Absences') =>$translator->trans( 'Absences en cours'),
                    $translator->trans( 'Agression' ) =>$translator->trans( 'Agression'),
                    $translator->trans( 'Autres ' ) =>$translator->trans( 'Autres '),
                    $translator->trans(  'Bagarres' ) =>$translator->trans( 'Bagarres'),
                    $translator->trans(  'Coiffure irrégulière' ) =>$translator->trans( 'Coiffure irrégulière'),
                    $translator->trans( 'Convocations' ) =>$translator->trans( 'Convocations parents'),
                    $translator->trans('Corvées' ) =>$translator->trans( 'Corvées'),
                    $translator->trans('Devoir non fait ' ) =>$translator->trans( 'homework non fait'),
                    $translator->trans('Drogue et stupéfiants' ) =>$translator->trans( 'Drogue et stupéfiants'),
                    $translator->trans('Escalade' ) =>$translator->trans( 'Escalade'),
                    $translator->trans( 'Flanerie' ) =>$translator->trans( 'Flanerie'),
                    $translator->trans('Exclusions temporaires' ) =>$translator->trans( 'Exclusions temporaires'),
                    $translator->trans(  'Interdiction d’accès avec motif' ) =>$translator->trans( 'Interdiction d’accès avec motif'),
                    $translator->trans(  'Jeux de hasard' ) =>$translator->trans( 'Jeux de hasard'),
                    $translator->trans(  'Maladie imaginaire' ) =>$translator->trans( 'Maladie imaginaire'),
                    $translator->trans( 'Permission fausse' ) =>$translator->trans( 'Permission fausse'),
                    $translator->trans( 'Port d’arme blanche' ) =>$translator->trans( 'Port d’arme blanche'),
                    $translator->trans( 'Port de pétard' ) =>$translator->trans('Port de pétard'),
                    $translator->trans( 'Retards' ) =>$translator->trans( 'Retards'),
                    $translator->trans('Sanctions' ) =>$translator->trans( 'Sanctions'), 
                    $translator->trans( 'Scolarité et autres frais  non payés' ) =>$translator->trans( 'Scolarité et autres frais  non payés'),
                    $translator->trans(  'Tenue non conforme' ) =>$translator->trans( 'Tenue non conforme'),
                    $translator->trans( 'Troubles' ) =>$translator->trans( 'Troubles en classe'),
                    $translator->trans( 'Vadrouille ' ) =>$translator->trans( 'Vadrouille '),
                    $translator->trans( 'Violence physique' ) =>$translator->trans( 'Violence physique'),
                    $translator->trans( 'Violence verbale' ) =>$translator->trans( 'Violence verbale'),

                ),'preferred_choices' => array('muppets', 'arr'),
            ))
            ->add('lieu')
            ->add('autre')
            //->add('compteur')
            ->add('description')
                  ->add('classes',EntityType::class,[
                    'class'=> Classes::class,
                    'group_by'=>'niveau',
                    'placeholder'=>$translator->trans('Select a class'),
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
                    $form->get('students')->setData($students);
                }
                 else{
                    
                     $this->addStudentField($form, null);

                     }
                     //$this->addCityField($form, null);

                 
            }
            );;
            //->add('dateMotif');
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
            'data_class' => 'App\Entity\Facteurs_disciplinaires'
        ));
                        $resolver->setRequired(['ets']);
                        $resolver->setRequired(['translator']);

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_facteurs_disciplinaires';
    }


}
