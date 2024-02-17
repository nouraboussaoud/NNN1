<?php

namespace App\Repository;

use App\Entity\SuiviLivraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuiviLivraison>
 *
 * @method SuiviLivraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviLivraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviLivraison[]    findAll()
 * @method SuiviLivraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviLivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviLivraison::class);
    }

//    /**
//     * @return SuiviLivraison[] Returns an array of SuiviLivraison objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SuiviLivraison
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
