<?php

namespace App\Repository;

use App\Entity\LegacyIndustry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LegacyIndustry|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegacyIndustry|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegacyIndustry[]    findAll()
 * @method LegacyIndustry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegacyIndustryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LegacyIndustry::class);
    }

    public function getSelection(int $page = 1, int $limit = 10, ?string $sortBy = null, bool $ascending = true, ?string $query = null): array
    {
        $builder = $this->createQueryBuilder('l')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        if ($sortBy) {
            $builder->orderBy('l.'.$sortBy, $ascending ? 'ASC' : 'DESC');
        }

        if ($query) {
            $builder->where('l.commodity like :query or l.name like :query');
            $builder->setParameter('query', sprintf('%%%s%%', $query));
        }

        return $builder
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function getRecordCount(?string $query = null): int
    {
        $builder = $this->createQueryBuilder('l')
            ->select('count(l.id)')
        ;

        if ($query) {
            $builder->where('l.commodity like :query');
            $builder->setParameter('query', sprintf('%%%s%%', $query));
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

//    /**
//     * @return LegacyIndustry[] Returns an array of LegacyIndustry objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LegacyIndustry
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
