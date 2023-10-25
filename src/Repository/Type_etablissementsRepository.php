<?php

namespace App\Repository;

use App\Entity\Type_etablissements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Type_etablissements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type_etablissements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type_etablissements[]    findAll()
 * @method Type_etablissements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Type_etablissementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type_etablissements::class);
    }

    // /**
    //  * @return Type_etablissements[] Returns an array of Type_etablissements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Type_etablissements
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
