<?php

namespace App\Form;

use App\Entity\AarCode;
use App\Entity\CarCard;
use App\Entity\Railroad;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarCardType extends AbstractType
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
            ->add('railroad', null, [
                'choice_label' => function (Railroad $railroad) {
                    return sprintf('%s - %s', $railroad->getReportingMark(), $railroad->getName());
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('railroad')
                        ->addOrderBy('railroad.reportingMark', 'ASC')
                        ;
                },
            ])
            ->add('carNumber')
            ->add('lengthCapacity')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarCard::class,
        ]);
    }
}
