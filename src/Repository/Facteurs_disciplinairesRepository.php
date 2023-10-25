<?php

namespace App\Repository;

use App\Entity\Facteurs_disciplinaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facteurs_disciplinaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facteurs_disciplinaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facteurs_disciplinaires[]    findAll()
 * @method Facteurs_disciplinaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Facteurs_disciplinairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facteurs_disciplinaires::class);
    }

    // /**
    //  * @return Facteurs_disciplinaires[] Returns an array of Facteurs_disciplinaires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facteurs_disciplinaires
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
