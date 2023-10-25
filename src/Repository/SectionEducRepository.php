<?php

namespace App\Repository;

use App\Entity\SectionEduc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectionEduc|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionEduc|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionEduc[]    findAll()
 * @method SectionEduc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionEducRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionEduc::class);
    }

    
              public function getSectionEduc()
    {

        $queryB=$this->createQueryBuilder('a');
        $queryB      ->select('c')
            ->from('App:SectionEduc', 'c');
         
        return $queryB;
    }

    
    
    // /**
    //  * @return SectionEduc[] Returns an array of SectionEduc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SectionEduc
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
