<?php

namespace App\Repository;

use App\Entity\AarCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AarCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method AarCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method AarCode[]    findAll()
 * @method AarCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AarCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AarCode::class);
    }
}
