<?php

namespace App\Repository;

use App\Entity\Waybill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Waybill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Waybill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Waybill[]    findAll()
 * @method Waybill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WaybillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Waybill::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('waybill')
            ->select('waybill', 'aarCode', 'consignee', 'consignee_location', 'shipper', 'shipper_location')
            ->leftJoin('waybill.aarCode', 'aarCode')
            ->leftJoin('waybill.consignee', 'consignee')
            ->leftJoin('consignee.location', 'consignee_location')
            ->leftJoin('waybill.shipper', 'shipper')
            ->leftJoin('shipper.location', 'shipper_location')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('w.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {
            $builder
                ->addOrderBy('aarCode.code', 'ASC')
            ;
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
        $builder = $this->createQueryBuilder('waybill')
            ->select('count(waybill.id)')
            ->leftJoin('waybill.aarCode', 'aarCode')
            ->leftJoin('waybill.consignee', 'consignee')
            ->leftJoin('consignee.location', 'consignee_location')
            ->leftJoin('waybill.shipper', 'shipper')
            ->leftJoin('shipper.location', 'shipper_location')
        ;

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
