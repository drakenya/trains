<?php

namespace App\Form;

use App\Entity\AarCode;
use App\Entity\Customer;
use App\Entity\Waybill;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WaybillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aarCode', null, [
                'choice_label' => function (AarCode $aarCode) {
                    return sprintf('%s - %s', $aarCode->getCode(), $aarCode->getCommonName());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('aarCode')
                        ->addOrderBy('aarCode.code', 'ASC')
                        ;
                },
                'group_by' => function (AarCode $aarCode) {
                    return $aarCode->getClass();
                },
            ])
            ->add('shipper', null, [
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
            ->add('consignee', null, [
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
            ->add('stopAt')
            ->add('StopAt2')
            ->add('instructionsExceptions')
            ->add('routeVia')
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
