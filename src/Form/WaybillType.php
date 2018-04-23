<?php

namespace App\Form;

use App\Entity\Waybill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WaybillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromAddress')
            ->add('toAddress')
            ->add('shipper')
            ->add('consignee')
            ->add('aarClass')
            ->add('lengthCapacity')
            ->add('routeVia')
            ->add('spotLocation')
            ->add('ladingQuantity')
            ->add('ladingDescription')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Waybill::class,
        ]);
    }
}
