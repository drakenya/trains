<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location', null, [
                'choice_label' => function (Location $location) {
                    return sprintf('%s, %s', $location->getStationName(), $location->getState());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('location')
                        ->addOrderBy('location.stationName', 'ASC')
                        ;
                },
                'group_by' => function (Location $location) {
                    return $location->getState();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
