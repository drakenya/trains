<?php

namespace App\Form;

use App\Entity\LegacyIndustry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegacyIndustryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('era')
            ->add('name')
            ->add('city')
            ->add('state')
            ->add('reportingMarks')
            ->add('shipReceive')
            ->add('commodity')
            ->add('stcc')
            ->add('reciprocal')
            ->add('source')
            ->add('externalSource')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LegacyIndustry::class,
        ]);
    }
}
