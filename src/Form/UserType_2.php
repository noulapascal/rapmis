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
use App\Repository\StaffRepository;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class UserType_2 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['dev'];
        $builder->add('staff', EntityType::class,array(
            'class'=> "App\Entity\Staff",
              'query_builder' => function (StaffRepository $er) use ($id) {
                    return $er->getStaffPerSchool($id);
                }
        ))
                ->add('username')
                ->add('locale', ChoiceType::class,[
                'choices'=>[
                    'Français'=>"fr",
                    'English'=>'en'
                ],
                'label'=>'Langue'
            ])

                ->add('email')
                ->add('phoneNumber')
                ->add('plainPassword',RepeatedType::class,[
                    'type'=>PasswordType::class, 
                    'invalid_message' => 'The password fields must match.',
    'options' => ['attr' => ['class' => 'password-field']],
    'required' => true,
    'first_options'  => ['label' => 'Password'],
    'second_options' => ['label' => 'Repeat Password']
                ])
                ->add('photoDeProfil',FileType::class,array('label' => 'Photo', 'required' => false))
                 ->add('typeDeCompte',ChoiceType::class, [
    'choices'  => [
        'Administrateur' => "ROLE_ADMIN_SEC",
        'Consultant' => "ROLE_STAFF",
        'Surveillant Général' => "ROLE_SG",
        'Professeur' => "ROLE_PROF",
        
    ],'multiple'=>False,
       'expanded'=>FALSE
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
