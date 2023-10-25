<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',ChoiceType::class,array(
                'choices'=>array(
                    'Matieres'=>'matieres',
                    'Pays'=>'country',
                    'Regions'=>'regions',
                    'Departement'=>'department',
                    'Ville'=>'city',
                    'Systeme educatif'=>'système éducatif',
                    'Section éducative'=>'section éducatif',
                    'Etablissement'=>'etablissement',
                    'Type d\'établissement'=>'type d\établissement',
                    'Classes'=>'classes',
                    'Membres du staff'=>'staff',
                    'Elèves/écoliers/étudiants'=>'students',
                    'Adresse'=>'addresses',
                ),
                'label'=>'Quel type de média voulez vous envoyer?'
            ) 
                /*,'text', array('label' => 'table name',
                'attr' => array('class' => 'input-medium search-query'))*/);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_recherche_upload';
    }


}
