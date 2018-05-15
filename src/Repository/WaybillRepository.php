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
        $builder = $this->createQueryBuilder('w')
            ->select('w')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('w.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        } else {
            $builder
                ->orderBy('w.aarClass', 'ASC')
            ;
        }

        if (!empty($query['waybill'])) {
            $builder->andWhere(sprintf('w.fromAddress like :waybill_query OR w.toAddress like :waybill_query OR w.shipper like :waybill_query OR w.consignee like :waybill_query OR w.ladingDescription like :waybill_query OR w.aarClass like :waybill_query'));
            $builder->setParameter('waybill_query', sprintf('%%%s%%', $query['waybill']));
        }

        return $builder
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getRecordCount(?array $query = null): int
    {
        $builder = $this->createQueryBuilder('w')
            ->select('count(w.id)')
        ;

        if (!empty($query['waybill'])) {
            $builder->andWhere(sprintf('w.fromAddress like :waybill_query OR w.toAddress like :waybill_query OR w.shipper like :waybill_query OR w.consignee like :waybill_query OR w.ladingDescription like :waybill_query OR w.aarClass like :waybill_query'));
            $builder->setParameter('waybill_query', sprintf('%%%s%%', $query['waybill']));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

//    /**
//     * @return Waybill[] Returns an array of Waybill objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Waybill
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
