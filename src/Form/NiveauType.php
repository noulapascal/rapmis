<?php

namespace App\Form;

use Doctrine\Common\Reflection\StaticReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use App\Form\MatieresType;
class NiveauType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
            ->add('name')
            ->add('matieres')
            ->add('typeEtablissement',ChoiceType::class,[
                'choices' => [
                        'Primaire'=>'3',
                        'Secondaire'=>'2',
                        'Universite'=>'1',
                
                    
            ]
                ])
            /*->add('matieres', CollectionType::class, [
                'label' => false,
                'entry_type' => MatieresType::class,
                'entry_options' => array('label' => false),
            ])*/


            ->add('description');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Niveau'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_niveau';
    }


}
