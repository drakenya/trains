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
