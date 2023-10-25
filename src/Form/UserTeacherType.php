<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Repository\TeacherRepository;


class UserTeacherType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

                 $id = $options['dev'];

        $builder->add('teacher', EntityType::class,array(
            'class'=> "App\Entity\Teacher",
             'query_builder' => function (TeacherRepository $er) use ($id) {
                    return $er->getTeacherPerSchool($id);
                }
        
        ))
               
                ->add('username')
                ->add('plainPassword',RepeatedType::class,[
                    'type'=>PasswordType::class, 
                    'invalid_message' => 'The password fields must match.',
    'options' => ['attr' => ['class' => 'password-field']],
    'required' => true,
    'first_options'  => ['label' => 'Password'],
    'second_options' => ['label' => 'Repeat Password']
                ])
                 ->add('typeDeCompte',ChoiceType::class, [
    'choices'  => [
        'Administrateur' => "ROLE_ADMIN_SEC",
        'Consultant' => "ROLE_STAFF",
        'Professeur' => "ROLE_PROF",
        
    ],'multiple'=>true,
       'expanded'=>true
]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
        $resolver->setRequired(['dev']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_user';
    }


}
