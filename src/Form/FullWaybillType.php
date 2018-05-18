<?php

namespace App\Form;

use App\Entity\CarCard;
use App\Entity\FullWaybill;
use App\Entity\Waybill;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FullWaybillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carCard', null, [
                'choice_label' => function (CarCard $carCard) {
                    return sprintf('%s %s', $carCard->getRailroad()->getReportingMark(), $carCard->getCarNumber());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('carCard')
                        ->innerJoin('carCard.railroad', 'railroad')
                        ->addOrderBy('railroad.reportingMark', 'ASC')
                        ->addOrderBy('carCard.carNumber', 'ASC')
                    ;
                },
                'group_by' => function (CarCard $carCard) {
                    return $carCard->getAarCode()->getCode();
                },
            ])
            ->add('waybill', null, [
                'choice_label' => function (Waybill $waybill) {
                    return sprintf(
                        '%s -> %s (%s)',
                        $waybill->getShipper()
                            ? sprintf(
                                '%s / %s, %s',
                                $waybill->getShipper()->getName(),
                                $waybill->getShipper()->getLocation()->getStationName(),
                                $waybill->getShipper()->getLocation()->getState()
                            )
                            : null,
                        $waybill->getConsignee()
                            ? sprintf(
                            '%s / %s, %s',
                            $waybill->getConsignee()->getName(),
                            $waybill->getConsignee()->getLocation()->getStationName(),
                            $waybill->getConsignee()->getLocation()->getState()
                        )
                            : null,
                        $waybill->getLadingDescription()
                    );
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('waybill')
                        ->leftJoin('waybill.aarCode', 'aarCode')
                        ->leftJoin('waybill.consignee', 'consignee')
                        ->leftJoin('consignee.location', 'consignee_location')
                        ->leftJoin('waybill.shipper', 'shipper')
                        ->leftJoin('shipper.location', 'shipper_location')
                        ->addOrderBy('aarCode.code', 'ASC')
                        ->addOrderBy('shipper_location.state', 'ASC')
                        ->addOrderBy('shipper_location.stationName', 'ASC')
                        ->addOrderBy('shipper.name', 'ASC')
                        ->addOrderBy('consignee_location.state', 'ASC')
                        ->addOrderBy('consignee_location.stationName', 'ASC')
                        ->addOrderBy('consignee.name', 'ASC')
                        ;
                },
                'group_by' => function (Waybill $waybill) {
                    return $waybill->getAarCode()->getCode();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FullWaybill::class,
        ]);
    }
}
