<?php

namespace App\Repository;

use App\Entity\Lacunes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lacunes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lacunes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lacunes[]    findAll()
 * @method Lacunes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LacunesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lacunes::class);
    }

    // /**
    //  * @return Lacunes[] Returns an array of Lacunes objects
    //  */
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
    public function findOneBySomeField($value): ?Lacunes
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
