<?php

// src/App/Form/RegistrationType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phoneNumber')
                ->add('photoDeProfil',FileType::class,array('label' => 'Photo', 'required' => false))
                 ->add('typeDeCompte',ChoiceType::class, [
    'choices'  => [
        'Administrateur' => "ROLE_ADMIN",
        'Consultant' => "ROLE_STAFF",
        'Professeur' => "ROLE_PROF",
        
    ],'multiple'=>False,
       'expanded'=>FALSE
])   ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}