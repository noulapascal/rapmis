<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Regions;
class SearchRegSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $country = $options['country'];
        $builder
            ->add('region',EntityType::class,
                    
            array(
                'class'=> Regions::class,
                'placeholder'=> $country ? 'Sélectionnez la region' : 'Sélectionnez d\'abord le pays',
                'mapped'=>false,
                'required'=>true,
                'auto_initialize' => false,
                'choices' => $country ? $country->getRegions() : []))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
        $resolver->setRequired(['country']);
    }
}
