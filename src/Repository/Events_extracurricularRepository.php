<?php

namespace App\Repository;

use App\Entity\Events_extracurricular;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Events_extracurricular|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events_extracurricular|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events_extracurricular[]    findAll()
 * @method Events_extracurricular[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Events_extracurricularRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events_extracurricular::class);
    }

    // /**
    //  * @return Events_extracurricular[] Returns an array of Events_extracurricular objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Events_extracurricular
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
