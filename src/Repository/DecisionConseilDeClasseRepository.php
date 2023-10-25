<?php

namespace App\Repository;

use App\Entity\DecisionConseilDeClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DecisionConseilDeClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecisionConseilDeClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecisionConseilDeClasse[]    findAll()
 * @method DecisionConseilDeClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecisionConseilDeClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecisionConseilDeClasse::class);
    }

    // /**
    //  * @return DecisionConseilDeClasse[] Returns an array of DecisionConseilDeClasse objects
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
    public function findOneBySomeField($value): ?DecisionConseilDeClasse
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
