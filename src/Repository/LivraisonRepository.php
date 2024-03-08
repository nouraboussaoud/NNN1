<?php

namespace App\Repository;

use App\Entity\Livraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livraison>
 *
 * @method Livraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livraison[]    findAll()
 * @method Livraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livraison::class);
    }

//    /**
//     * @return Livraison[] Returns an array of Livraison objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livraison
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
function OrderName(){
    $em = $this->getEntityManager();
    return $em->createQuery('SELECT a FROM App\Entity\Livraison a ORDER BY a.NomC ASC')
             ->getResult();
}
public function countByRegion()
    {
        //$query = $this->createQueryBuilder('c')
        //->select('SUBSTRING(d.date, 1, 10) as date, COUNT(c) as count')
        //->groupBy('date')
        //;
        //return $query->getQuery()->getResult();
        $query = $this->getEntityManager()->createQuery("
           SELECT l.state as regionL, count(l) as countL FROM App\Entity\Livraison l where l.state IS NOT NULL GROUP BY regionL 
       ");
        return $query->getResult();
    }


}
