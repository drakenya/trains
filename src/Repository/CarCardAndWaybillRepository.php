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
