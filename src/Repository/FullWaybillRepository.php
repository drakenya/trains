<?php

namespace App\Repository;

use App\Entity\FullWaybill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FullWaybill|null find($id, $lockMode = null, $lockVersion = null)
 * @method FullWaybill|null findOneBy(array $criteria, array $orderBy = null)
 * @method FullWaybill[]    findAll()
 * @method FullWaybill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FullWaybillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FullWaybill::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('fullWaybill')
            ->select('fullWaybill', 'carCard', 'carCard_aarCode', 'railroad', 'waybill', 'aarCode', 'consignee', 'consignee_location', 'shipper', 'shipper_location')
            ->innerJoin('fullWaybill.carCard', 'carCard')
            ->innerJoin('carCard.aarCode', 'carCard_aarCode')
            ->innerJoin('carCard.railroad', 'railroad')
            ->innerJoin('fullWaybill.waybill', 'waybill')
            ->leftJoin('waybill.aarCode', 'aarCode')
            ->leftJoin('waybill.consignee', 'consignee')
            ->leftJoin('consignee.location', 'consignee_location')
            ->leftJoin('waybill.shipper', 'shipper')
            ->leftJoin('shipper.location', 'shipper_location')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('fullWaybill.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {

        }

        if (!empty($query['carCard'])) {
            $builder
                ->orWhere('railroad.reportingMark like :carCard_query')
                ->orWhere('carCard.carNumber like :carCard_query')
                ->orWhere('carCard_aarCode.class like :carCard_query')
            ;
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }
        if (!empty($query['waybill'])) {
            $builder
                ->orWhere('shipper.name like :waybill_query')
                ->orWhere('shipper_location.stationName like :waybill_query')
                ->orWhere('shipper_location.state like :waybill_query')
                ->orWhere('consignee.name like :waybill_query')
                ->orWhere('consignee_location.stationName like :waybill_query')
                ->orWhere('consignee_location.state like :waybill_query')
                ->orWhere('waybill.ladingDescription like :waybill_query')
                ->orWhere('aarCode.code like :waybill_query')
            ;
            $builder->setParameter('waybill_query', sprintf('%%%s%%', $query['waybill']));
        }

        return $builder
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getRecordCount(?array $query = null): int
    {
        $builder = $this->createQueryBuilder('fullWaybill')
            ->select('count(fullWaybill.id)')
            ->innerJoin('fullWaybill.carCard', 'carCard')
            ->innerJoin('carCard.aarCode', 'carCard_aarCode')
            ->innerJoin('carCard.railroad', 'railroad')
            ->innerJoin('fullWaybill.waybill', 'waybill')
            ->leftJoin('waybill.aarCode', 'aarCode')
            ->leftJoin('waybill.consignee', 'consignee')
            ->leftJoin('consignee.location', 'consignee_location')
            ->leftJoin('waybill.shipper', 'shipper')
            ->leftJoin('shipper.location', 'shipper_location')
        ;

        if (!empty($query['carCard'])) {
            $builder
                ->orWhere('railroad.reportingMark like :carCard_query')
                ->orWhere('carCard.carNumber like :carCard_query')
                ->orWhere('carCard_aarCode.class like :carCard_query')
            ;
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }
        if (!empty($query['waybill'])) {
            $builder
                ->orWhere('shipper.name like :waybill_query')
                ->orWhere('shipper_location.stationName like :waybill_query')
                ->orWhere('shipper_location.state like :waybill_query')
                ->orWhere('consignee.name like :waybill_query')
                ->orWhere('consignee_location.stationName like :waybill_query')
                ->orWhere('consignee_location.state like :waybill_query')
                ->orWhere('waybill.ladingDescription like :waybill_query')
                ->orWhere('aarCode.code like :waybill_query')
            ;
            $builder->setParameter('waybill_query', sprintf('%%%s%%', $query['waybill']));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
