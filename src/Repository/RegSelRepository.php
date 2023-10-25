<?php

namespace App\Repository;

use App\Entity\RegSel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegSel|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegSel|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegSel[]    findAll()
 * @method RegSel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegSelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegSel::class);
    }

    // /**
    //  * @return RegSel[] Returns an array of RegSel objects
    //  */
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
    public function findOneBySomeField($value): ?RegSel
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
