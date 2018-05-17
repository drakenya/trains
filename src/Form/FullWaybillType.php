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
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('cc')
                        ->addOrderBy('cc.reportingMark', 'ASC')
                        ->addOrderBy('cc.carNumber', 'ASC')
                    ;
                },
                'group_by' => function (CarCard $carCard, $key, $index) {
                    return $carCard->getAarType();
                },
            ])
            ->add('waybill', null, [
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('w')
                        ->addOrderBy('w.aarClass', 'ASC')
                        ->addOrderBy('w.fromAddress', 'ASC')
                        ->addOrderBy('w.shipper', 'ASC')
                        ->addOrderBy('w.toAddress', 'ASC')
                        ->addOrderBy('w.consignee', 'ASC')
                        ;
                },
                'group_by' => function (Waybill $waybill, $key, $index) {
                    return $waybill->getAarClass();
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
