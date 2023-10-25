<?php

namespace App\Repository;

use App\Entity\Enseignants_titulaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enseignants_titulaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enseignants_titulaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enseignants_titulaire[]    findAll()
 * @method Enseignants_titulaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Enseignants_titulaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enseignants_titulaire::class);
    }

    
    
    public function findTeacherPerSchool($dev)
    {

        $queryB = $this->createQueryBuilder('a');
        $queryB->select('t')
            ->from('App:Enseignants_titulaire', 't')
            ->Join('t.teacher', 's')
            ->where('s.etablissements = :dev')
            ->setParameter('dev', $dev);
        return $queryB;
    }

    // /**
    //  * @return Enseignants_titulaire[] Returns an array of Enseignants_titulaire objects
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
    public function findOneBySomeField($value): ?Enseignants_titulaire
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
