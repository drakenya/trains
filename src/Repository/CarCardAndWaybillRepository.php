<?php

namespace App\Repository;

use App\Entity\CarCardAndWaybill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarCardAndWaybill|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarCardAndWaybill|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarCardAndWaybill[]    findAll()
 * @method CarCardAndWaybill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarCardAndWaybillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarCardAndWaybill::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?array $query = null): array
    {
        $builder = $this->createQueryBuilder('ccaw')
            ->select('ccaw', 'cc', 'w')
            ->innerJoin('ccaw.carCard', 'cc')
            ->innerJoin('ccaw.waybill', 'w')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('ccaw.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        }

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('cc.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR cc.aarType like :carCard_query'));
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
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
        $builder = $this->createQueryBuilder('ccaw')
            ->select('count(ccaw.id)')
            ->innerJoin('ccaw.carCard', 'cc')
            ->innerJoin('ccaw.waybill', 'w')
        ;

        if (!empty($query['carCard'])) {
            $builder->andWhere(sprintf('cc.reportingMark like :carCard_query OR cc.carNumber like :carCard_query OR cc.aarType like :carCard_query'));
            $builder->setParameter('carCard_query', sprintf('%%%s%%', $query['carCard']));
        }
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
//     * @return CarCardAndWaybill[] Returns an array of CarCardAndWaybill objects
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
    public function findOneBySomeField($value): ?CarCardAndWaybill
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
