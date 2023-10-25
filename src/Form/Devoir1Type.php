<?php

namespace App\Form;

use App\Entity\Devoir;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Devoir1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('homework')
            ->add('givenOn')
            ->add('doBefore')
            ->add('updateAt')
            ->add('subject')
            ->add('class')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devoir::class,
        ]);
    }
}
