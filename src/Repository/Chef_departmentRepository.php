<?php

namespace App\Repository;

use App\Entity\Chef_department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chef_department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chef_department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chef_department[]    findAll()
 * @method Chef_department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Chef_departmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chef_department::class);
    }

    // /**
    //  * @return Chef_department[] Returns an array of Chef_department objects
    //  */
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
    public function findOneBySomeField($value): ?Chef_department
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
