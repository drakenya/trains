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

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('cc')
            ->select('cc')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('cc.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {
            $builder
                ->addOrderBy('cc.carNumber', 'ASC')
                ->addOrderBy('cc.reportingMark', 'ASC')
            ;
        }

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('cc.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR cc.aarType like :carCard_query'));
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
        ;

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('cc.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR cc.aarType like :carCard_query'));
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

//    /**
//     * @return CarCard[] Returns an array of CarCard objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarCard
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
