<?php

namespace App\Repository;

use App\Entity\Students;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Students|null find($id, $lockMode = null, $lockVersion = null)
 * @method Students|null findOneBy(array $criteria, array $orderBy = null)
 * @method Students[]    findAll()
 * @method Students[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Students::class);
    }

    
      public function getStudentPerSchool($dev)
    {
$entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT s, c
        FROM App\Entity\Students s
        INNER JOIN s.classes c
        WHERE c.id = :id'
    )->setParameter('id', $dev);

    }
    
       public function getStudentsPerClasses($dev)
    {

        $queryB=$this->createQueryBuilder('a');
        $queryB->select('s')
                ->from('App:Students', 's');
$query='s.classes = :dev ';
           

        $i=0;
                
            foreach ($dev as $value){   
                $query=$query.'or s.classes = :dev'."$i ";
                 $queryB->where($query);
                 
                if($i==0){
                     $queryB ->setParameter('dev', $dev[0]);
                }
            $queryB ->setParameter('dev'."$i", $value);
            $i++;
                    
            }
            
        return $queryB;
    }
    
    public function search($titre) {
        $title = str_replace(' ', '%', $titre);
        return $this->createQueryBuilder('Students')
           ->join('Students.classes','c')
           ->join('c.niveau','n')
           ->join('c.etablissements','e')
           ->Where('c.name LIKE :nom or n.name LIKE :nom or  Students.firstName LIKE :nom or Students.name LIKE :nom or e.name LIKE :nom or e.sigle LIKE :nom')

           ->setParameter('nom', '%'.strtolower($title).'%')
           ->getQuery()
           ->execute();
   }
    public function Adminsearch($titre,$school) {
        $title = str_replace(' ', '%', $titre);
        $id=$school->getId();
       return $this->createQueryBuilder('Students')
           ->Where('c.name LIKE :nom or Students.firstName LIKE :nom or Students.name LIKE :nom or e.name LIKE :nom or e.sigle LIKE :nom')
               ->join('Students.classes', 'c')
           ->join("c.etablissements", 'e')
           ->join("c.niveau", 'n')
               ->andWhere("e.id = $id")
           ->setParameter('nom', '%'.strtolower($title).'%')
               ->orderBy('n.id')
           ->getQuery()
           ->execute();
   }
   
   
       public function RegSearch($titre,$reg) {
                   $title = str_replace(' ', '%', $titre);
        $id = $reg->getId();
       return $this->createQueryBuilder('Students')
           ->Where('c.name LIKE :nom or Students.firstName LIKE :nom or Students.name LIKE :nom or e.name LIKE :nom or e.sigle LIKE :nom')
               ->join('Students.classes', 'c')
           ->join("c.etablissements", 'e')
           ->join("e.city", 'city')
           ->join("city.departments", 'd')
           ->join("d.regions", 'r')
               ->andWhere("r.id = $id")
           ->setParameter('nom', '%'.strtolower($title).'%')
           ->getQuery()
           ->execute();
   }
   
   
       public function Depsearch($titre,$dept) {
           $title = str_replace(' ', '%', $titre);
        $id=$dept->getId();
       return $this->createQueryBuilder('Students')
           ->Where('c.name LIKE :nom or Students.firstName LIKE :nom or Students.name LIKE :nom or e.name LIKE :nom or e.sigle LIKE :nom')
               ->join('Students.classes', 'c')
           ->join("c.etablissements", 'e')
           ->join("e.city", 'city')
           ->join("city.departments", 'd')
               ->andWhere("d.id = $id")
           ->setParameter('nom', '%'.strtolower($title).'%')
           ->getQuery()
           ->execute();
   }
       public function Citysearch($titre,$city) {
           $title = str_replace(' ', '%', $titre);
        $id=$city->getId();
       return $this->createQueryBuilder('Students')
           ->andWhere('Students.name LIKE :nom')
               ->join('Students.classes', 'c')
           ->join("c.etablissements", 'e')
           ->join("e.city", 'city')
               ->andWhere("city.id = $id")
           ->setParameter('nom', '%'.strtolower($title).'%')
           ->getQuery()
           ->execute();
   }
   
       public function Subsearch($titre,$sub) {
           $title = str_replace(' ', '%', $titre);
        $id=$sub->getId();
       return $this->createQueryBuilder('Students')
           ->andWhere('Students.name LIKE :nom')
               ->join('Students.classes', 'c')
           ->join("c.etablissements", 'e')
           ->join("e.subdivision", 'city')
               
           
               ->andWhere("city.id = $id")
           ->setParameter('nom', '%'.strtolower($title).'%')
           ->getQuery()
           ->execute();
   }

    // /**
    //  * @return Students[] Returns an array of Students objects
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
    public function findOneBySomeField($value): ?Students
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
