<?php

namespace App\Repository;

use App\Entity\CarCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarCard[]    findAll()
 * @method CarCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarCardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarCard::class);
    }

    /**
     * @param int         $page
     * @param int         $limit
     * @param null|string $sortBy
     * @param bool        $ascending
     * @param array|null  $query
     *
     * @return CarCard[]
     */
    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('cc')
            ->select('cc', 'r', 'ac', 'count(distinct(fullWaybills)) as fullWaybills_count', 'count(distinct(fullEmptyCarBills)) as fullEmptyCarBills_count')
            ->innerJoin('cc.railroad', 'r')
            ->innerJoin('cc.aarCode', 'ac')
            ->leftJoin('cc.fullWaybills', 'fullWaybills')
            ->leftJoin('cc.fullEmptyCarBills', 'fullEmptyCarBills')
            ->groupBy('cc')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->addOrderBy('cc.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {
            $builder
                ->addOrderBy('r.reportingMark', 'ASC')
                ->addOrderBy('cc.carNumber', 'ASC')
            ;
        }

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('r.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR ac.code like :carCard_query'));
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }

        return $builder
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getRecordCount(?array $query = null): int
    {
        $builder = $this->createQueryBuilder('cc')
            ->select('count(cc.id)')
            ->innerJoin('cc.railroad', 'r')
            ->innerJoin('cc.aarCode', 'ac')
        ;

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('r.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR ac.code like :carCard_query'));
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
