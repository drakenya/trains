<?php

namespace App\Repository;

use App\Entity\EmptyCarBill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmptyCarBill|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmptyCarBill|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmptyCarBill[]    findAll()
 * @method EmptyCarBill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmptyCarBillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmptyCarBill::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('emptyCarBill')
            ->select('emptyCarBill', 'homeBilledFrom', 'loadingTo', 'loadingBilledFrom', 'loadingShipper', 'location')
            ->leftJoin('emptyCarBill.homeBilledFrom', 'homeBilledFrom')
            ->leftJoin('emptyCarBill.loadingBilledFrom', 'loadingBilledFrom')
            ->leftJoin('emptyCarBill.loadingTo', 'loadingTo')
            ->leftJoin('emptyCarBill.loadingShipper', 'loadingShipper')
            ->leftJoin('loadingShipper.location', 'location')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('emptyCarBill.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {

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
        $builder = $this->createQueryBuilder('emptyCarBill')
            ->select('count(emptyCarBill.id)')
            ->leftJoin('emptyCarBill.homeBilledFrom', 'homeBilledFrom')
            ->leftJoin('emptyCarBill.loadingBilledFrom', 'loadingBilledFrom')
            ->leftJoin('emptyCarBill.loadingTo', 'loadingTo')
            ->leftJoin('emptyCarBill.loadingShipper', 'loadingShipper')
            ->leftJoin('loadingShipper.location', 'location')
        ;

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
