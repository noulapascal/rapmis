<?php

namespace App\Repository;

use App\Entity\Fiche_parents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fiche_parents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche_parents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche_parents[]    findAll()
 * @method Fiche_parents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Fiche_parentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche_parents::class);
    }

    // /**
    //  * @return Fiche_parents[] Returns an array of Fiche_parents objects
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
    public function findOneBySomeField($value): ?Fiche_parents
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
