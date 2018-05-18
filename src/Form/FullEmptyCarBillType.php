<?php

namespace App\Form;

use App\Entity\CarCard;
use App\Entity\EmptyCarBill;
use App\Entity\FullEmptyCarBill;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FullEmptyCarBillType extends AbstractType
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
            ->add('emptyCarBill', null, [
                'choice_label' => function (EmptyCarBill $emptyCarBill) {
                    if ($emptyCarBill->getHomeBilledFrom()) {
                        return sprintf(
                            '%s, %s',
                            $emptyCarBill->getHomeBilledFrom()->getStationName(),
                            $emptyCarBill->getHomeBilledFrom()->getState()
                        );
                    } elseif ($emptyCarBill->getLoadingShipper()) {
                        return sprintf(
                            '%s, %s / %s',
                            $emptyCarBill->getLoadingShipper()->getLocation()->getStationName(),
                            $emptyCarBill->getLoadingShipper()->getLocation()->getState(),
                            $emptyCarBill->getLoadingShipper()->getName()
                        );
                    } else {
                        return sprintf(
                            '%s, %s',
                            $emptyCarBill->getLoadingBilledFrom()->getStationName(),
                            $emptyCarBill->getLoadingBilledFrom()->getState()
                        );
                    }
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('emptyCarBill')
                        ->select('emptyCarBill')
                        ->addSelect('COALESCE(homeBilledFrom.state, location.state, loadingBilledFrom.state) as HIDDEN primarySort')
                        ->addSelect('COALESCE(homeBilledFrom.stationName, location.stationName, loadingBilledFrom.stationName) as HIDDEN secondarySort')
                        ->leftJoin('emptyCarBill.homeBilledFrom', 'homeBilledFrom')
                        ->leftJoin('emptyCarBill.loadingBilledFrom', 'loadingBilledFrom')
                        ->leftJoin('emptyCarBill.loadingShipper', 'loadingShipper')
                        ->leftJoin('loadingShipper.location', 'location')
                        ->addOrderBy('primarySort', 'ASC')
                        ->addOrderBy('secondarySort', 'ASC')
                        ->addOrderBy('loadingShipper.name', 'ASC')
                    ;
                },
                'group_by' => function (EmptyCarBill $emptyCarBill) {
                    if ($emptyCarBill->getHomeBilledFrom()) {
                        return $emptyCarBill->getHomeBilledFrom()->getState();
                    } elseif ($emptyCarBill->getLoadingShipper()) {
                        return $emptyCarBill->getLoadingShipper()->getLocation()->getState();
                    } else {
                        return $emptyCarBill->getLoadingBilledFrom()->getState();
                    }
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FullEmptyCarBill::class,
        ]);
    }
}
