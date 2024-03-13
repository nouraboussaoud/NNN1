<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }


//    /**
//     * @return Reclamation[] Returns an array of Reclamation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reclamation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getDistinctCategories(): array
{
    // Utilisez le QueryBuilder pour récupérer les catégories distinctes
    $queryBuilder = $this->createQueryBuilder('r');
    $queryBuilder->select('DISTINCT r.categorie');
    $result = $queryBuilder->getQuery()->getResult();

    return array_column($result, 'categorie');
}

public function countByCategory(string $category): int
{
    // Utilisez le QueryBuilder pour compter le nombre de réclamations pour une catégorie donnée
    $queryBuilder = $this->createQueryBuilder('r');
    $queryBuilder->select('COUNT(r.id)');
    $queryBuilder->where('r.categorie = :category');
    $queryBuilder->setParameter('category', $category);

    return (int)$queryBuilder->getQuery()->getSingleScalarResult();
}

public function countAll(): int
{
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery('SELECT COUNT(r.id) FROM App\Entity\Reclamation r');
    return (int) $query->getSingleScalarResult();
}


/**
     * Search reclamations by category.
     *
     * @param string $category
     * @return Reclamation[]
     */
    public function searchByCategory(string $category): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.categorie LIKE :category')
            ->setParameter('category', '%' . $category . '%')
            ->getQuery()
            ->getResult();
    }



}
