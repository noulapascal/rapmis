<?php

namespace App\Form;

use Symfony\Component\OptionResolver\OptionsResolverInterface;
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
use Symfony\Component\Form\FormEvent;
use App\Repository\RegionsRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\Form\FormEvents;
use App\Entity\Regions;
use App\Entity\Department;
use App\Entity\City;
use App\Entity\Country;
use Symfony\Component\Form\FormInterface;


class UserRegType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id=$options['dev'];

        $builder->add('username')
                ->add('locale', ChoiceType::class,[
                'choices'=>[
                    'Français'=>"fr",
                    'English'=>'en'
                ],
                'label'=>'Langue'
            ])

                ->add('email')
                ->add('phoneNumber')
                ->add('typeEtablissement')
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
        'Regional' => "ROLE_REGION",
        
    ],'multiple'=>False,
       'expanded'=>FALSE
])
                ->add('phoneNumber')
                ->add('zone', EntityType::class, array(
                'class'=>'App\Entity\Regions',
                'placeholder'=>'selectionnez la région',
                'required'=>true,
                    'query_builder' => function (RegionsRepository $er) use ($id) {
                    return $er->getRegionsPerCountry($id);
                },
            ));    }
    
    /**
     * {@inheritdoc}
     */
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
                'cascade_validation' => true,
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
 
    public function setDefaultOptions(OptionsResolverInterface $resolver)
{
       $resolver->setDefaults(array(
           'data_class' => User::class,
           'cascade_validation' => true,
       ));
}
   

}
