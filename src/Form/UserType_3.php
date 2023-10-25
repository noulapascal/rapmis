<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Teacher;
use App\Entity\Regions;
use App\Entity\Department;
use App\Entity\City;

class UserType_3 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('username')
                ->add('locale', ChoiceType::class,[
                'choices'=>[
                    'Français'=>"fr",
                    'English'=>'en'
                ],
                'label'=>'Langue'
            ])

                ->add('email')
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
        'Super Administrateur' => "ROLE_SUPER_ADMIN",
        'Administrateur' => "ROLE_ADMIN",
        'Regional' => "ROLE_REGION",
        'Ministeriel' => "ROLE_PAYS",
        'Departemental' => "ROLE_DEPT",
        'Communal' => "ROLE_ARR",
        
    ],'multiple'=>False,
       'expanded'=>FALSE
])
                ->add('phoneNumber')
                 ->add('country', EntityType::class, array(
                'class'=>'App\Entity\Country',
                'placeholder'=>'selectionnez le pays',
                'mapped'=>false,
                'required'=>false
            ))
                ->add('etablissements');
    }
    
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_user';
    }


}
