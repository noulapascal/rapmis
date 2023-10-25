<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Department;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Subdivision;
use App\Entity\Regions;

class SearchDeptSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $country = $options['country'];
        $builder
            ->add('Department', EntityType::class, array(
                'class'=> Department::class,
                'placeholder'=>'selectionnez le Departement',
                'group_by'=>'regions',
                'required'=>true,
                'choices' => $country ? $country: []

            ))
        ;
    }
    
        
        
        public function addSubField(Department $dept){
            
            
        
        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
        $resolver->setRequired(['country']);
    }
}
