<?php

namespace App\Repository;

use App\Entity\Etablissements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etablissements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etablissements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etablissements[]    findAll()
 * @method Etablissements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissements::class);
    }

    
    
    public function findWithCountry(int $id){

        return $this->createQueryBuilder('e')
        ->select('e, v, d, r, c')
            ->join('e.city', 'v')
            ->join('v.departments', 'd')
            ->join('d.regions', 'r')
            ->join('r.country', 'c')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function findAllWithCountry(){

        return $this->createQueryBuilder('e')
            ->select('e, v, d, r, c')
            ->join('e.city', 'v')
            ->join('v.departments', 'd')
            ->join('d.regions', 'r')
            ->join('r.country', 'c')
            ->getQuery()
            ->getResult();
    }
    
    
    public function findWithRegions(int $id){

        return $this->createQueryBuilder('e')
        ->select('App:Etablissements','e')
            ->join('e.city', 'v')
            ->join('v.departments', 'd')
            ->join('d.regions', 'r')
            ->join('r.country', 'c')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    // /**
    //  * @return Etablissements[] Returns an array of Etablissements objects
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
    public function findOneBySomeField($value): ?Etablissements
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
