<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Fiche_parentsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('namePrenamePere')->add('profession')->add('residence')->add('medecinFamille')->add('telPere')->add('emailPere')->add('signature')->add('namePrenameMere')->add('professionMere')->add('assurancePere')->add('assuranceMere')->add('residenceMere')->add('medecinFamilleMere')->add('telMere')->add('emailMere')->add('signatureMere')->add('namePrenameTuteur')->add('professionTuteur')->add('assuranceTuteur')->add('residenceTuteur')->add('medecinFamilleTuteur')->add('telTuteur')->add('emailTuteur')->add('signatureTuteur')->add('frerename1')->add('frerename2')->add('frerename3')->add('telFrere1')->add('telFrere2')->add('telFrere3')->add('mailFrere1')->add('mailFrere2')->add('mailFrere3')->add('niveauScolaireFrere1')->add('niveauScolaireFrere2')->add('niveauScolaireFrere3')->add('professionFrere1')->add('professionFrere2')->add('professionFrere3')->add('photo_pere')->add('photo_mere')->add('photo_tuteur')->add('students');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Fiche_parents'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_fiche_parents';
    }


}
