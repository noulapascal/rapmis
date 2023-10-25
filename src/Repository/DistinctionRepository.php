<?php

namespace App\Repository;

use App\Entity\Distinction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Distinction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distinction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distinction[]    findAll()
 * @method Distinction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistinctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Distinction::class);
    }

    // /**
    //  * @return Distinction[] Returns an array of Distinction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Distinction
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
