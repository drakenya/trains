<?php

namespace App\Repository;

use App\Entity\Railroad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Railroad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Railroad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Railroad[]    findAll()
 * @method Railroad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RailroadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Railroad::class);
    }

//    /**
//     * @return Railroad[] Returns an array of Railroad objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Railroad
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
