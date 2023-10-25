<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Subdivision;
class SearchSubSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder
            ->add('subdivision',EntityType::class,
            array(
                'class'=> Subdivision::class,
                'placeholder'=> !empty($city )? 'sélectionnez votre arrondissement' : 'sélectionnez d\'abord la ville',
                'group_by'=>'city',
                'required'=>false,
                'auto_initialize' => false,
                //'choices' => $city ? $city->getSubdivisions() : []
                )
         )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
