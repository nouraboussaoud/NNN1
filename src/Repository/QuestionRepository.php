<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }


    
    public function showquestionbyid($id)
    {
        return $this->createQueryBuilder('e') 
        ->andWhere('e.quiz = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }


    public function Deletequeswehere($id)
{
    $em = $this->getEntityManager();
    $query = $em->createQuery(
        'DELETE App\Entity\Question a WHERE a.quiz = :id'
    )->setParameter('id', $id);

    return $query->getResult();
}


  

    public function getTotalPointsForQuiz(Quiz $quiz): int
    {
        return $this->createQueryBuilder('q')
            ->select('SUM(q.points)')
            ->where('q.quiz = :quiz')
            ->setParameter('quiz', $quiz)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }


//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
