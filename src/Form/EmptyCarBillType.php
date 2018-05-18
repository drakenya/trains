<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\EmptyCarBill;
use App\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmptyCarBillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('homeBilledFrom', null, [
                'choice_label' => function (Location $location) {
                    return sprintf('%s, %s', $location->getStationName(), $location->getState());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('location')
                        ->addOrderBy('location.state', 'ASC')
                        ->addOrderBy('location.stationName', 'ASC')
                        ;
                },
                'group_by' => function (Location $location) {
                    return $location->getState();
                },
            ])
            ->add('homeToOrVia')
            ->add('loadingBilledFrom', null, [
                'choice_label' => function (Location $location) {
                    return sprintf('%s, %s', $location->getStationName(), $location->getState());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('location')
                        ->addOrderBy('location.state', 'ASC')
                        ->addOrderBy('location.stationName', 'ASC')
                        ;
                },
                'group_by' => function (Location $location) {
                    return $location->getState();
                },
            ])
            ->add('loadingTo', null, [
                'choice_label' => function (Location $location) {
                    return sprintf('%s, %s', $location->getStationName(), $location->getState());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('location')
                        ->addOrderBy('location.state', 'ASC')
                        ->addOrderBy('location.stationName', 'ASC')
                        ;
                },
                'group_by' => function (Location $location) {
                    return $location->getState();
                },
            ])
            ->add('loadingShipper', null, [
                'choice_label' => function (Customer $customer) {
                    return sprintf('%s, %s - %s', $customer->getLocation()->getStationName(), $customer->getLocation()->getState(), $customer->getName());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('customer')
                        ->innerJoin('customer.location', 'location')
                        ->addOrderBy('location.state', 'ASC')
                        ->addOrderBy('location.stationName', 'ASC')
                        ;
                },
                'group_by' => function (Customer $customer) {
                    return $customer->getLocation()->getState();
                },
            ])
            ->add('loadingSpot')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmptyCarBill::class,
        ]);
    }
}
