<?php

namespace App\Repository;

use App\Entity\FullEmptyCarBill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FullEmptyCarBill|null find($id, $lockMode = null, $lockVersion = null)
 * @method FullEmptyCarBill|null findOneBy(array $criteria, array $orderBy = null)
 * @method FullEmptyCarBill[]    findAll()
 * @method FullEmptyCarBill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FullEmptyCarBillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FullEmptyCarBill::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('fullEmptyCarBill')
            ->select('fullEmptyCarBill', 'carCard', 'carCard_aarCode', 'railroad', 'emptyCarBill', 'homeBilledFrom', 'loadingTo', 'loadingBilledFrom', 'loadingShipper', 'location')
            ->innerJoin('fullEmptyCarBill.carCard', 'carCard')
            ->innerJoin('carCard.aarCode', 'carCard_aarCode')
            ->innerJoin('carCard.railroad', 'railroad')
            ->innerJoin('fullEmptyCarBill.emptyCarBill', 'emptyCarBill')
            ->leftJoin('emptyCarBill.homeBilledFrom', 'homeBilledFrom')
            ->leftJoin('emptyCarBill.loadingBilledFrom', 'loadingBilledFrom')
            ->leftJoin('emptyCarBill.loadingTo', 'loadingTo')
            ->leftJoin('emptyCarBill.loadingShipper', 'loadingShipper')
            ->leftJoin('loadingShipper.location', 'location')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('fullEmptyCarBill.'.$sortBy, $ascending ? 'ASC' : 'DESC');
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
        if (!empty($query['emptyCarBill'])) {
            $builder
                ->orWhere('homeBilledFrom.stationName like :emptyCarBill_query')
                ->orWhere('homeBilledFrom.state like :emptyCarBill_query')
                ->orWhere('loadingBilledFrom.stationName like :emptyCarBill_query')
                ->orWhere('loadingBilledFrom.state like :emptyCarBill_query')
                ->orWhere('loadingShipper.name like :emptyCarBill_query')
                ->orWhere('location.stationName like :emptyCarBill_query')
                ->orWhere('location.state like :emptyCarBill_query')
            ;
            $builder->setParameter('emptyCarBill_query', sprintf('%%%s%%', $query['emptyCarBill']));
        }

        return $builder
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getRecordCount(?array $query = null): int
    {
        $builder = $this->createQueryBuilder('fullEmptyCarBill')
            ->select('count(fullEmptyCarBill.id)')
            ->innerJoin('fullEmptyCarBill.carCard', 'carCard')
            ->innerJoin('carCard.aarCode', 'carCard_aarCode')
            ->innerJoin('carCard.railroad', 'railroad')
            ->innerJoin('fullEmptyCarBill.emptyCarBill', 'emptyCarBill')
            ->leftJoin('emptyCarBill.homeBilledFrom', 'homeBilledFrom')
            ->leftJoin('emptyCarBill.loadingBilledFrom', 'loadingBilledFrom')
            ->leftJoin('emptyCarBill.loadingShipper', 'loadingShipper')
            ->leftJoin('loadingShipper.location', 'location')
        ;

        if (!empty($query['carCard'])) {
            $builder
                ->orWhere('railroad.reportingMark like :carCard_query')
                ->orWhere('carCard.carNumber like :carCard_query')
                ->orWhere('carCard_aarCode.class like :carCard_query')
            ;
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }
        if (!empty($query['emptyCarBill'])) {
            $builder
                ->orWhere('homeBilledFrom.stationName like :emptyCarBill_query')
                ->orWhere('homeBilledFrom.state like :emptyCarBill_query')
                ->orWhere('loadingBilledFrom.stationName like :emptyCarBill_query')
                ->orWhere('loadingBilledFrom.state like :emptyCarBill_query')
                ->orWhere('loadingShipper.name like :emptyCarBill_query')
                ->orWhere('location.stationName like :emptyCarBill_query')
                ->orWhere('location.state like :emptyCarBill_query')
            ;
            $builder->setParameter('emptyCarBill_query', sprintf('%%%s%%', $query['emptyCarBill']));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
