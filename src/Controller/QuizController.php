<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Entity\Quiz;
use App\Entity\User;
use App\Form\QuizType;
use App\Repository\CertificationRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
   






    //------------------affiche quiz ------------------------------


    #[Route('/quizDasha', name: 'quizshow')]
    public function showquiz(QuizRepository $rep): Response
    { {
            return $this->render(
                'User/quiz/quiz.html.twig',
                ['quiz' => $rep->findAll(),]
            );
        }
    }





    //------------------add quiz  and show quiz------------------------------




    #[Route('/quizDash', name: 'quizadd')]
    public function addquiz( ManagerRegistry $manager, Request $req, QuizRepository $repo): Response
    {
        

        $p=new Quiz();
        
        $em=$manager->getManager();
        $formRev = $this->createform(QuizType::class,$p);

        $formRev->handleRequest($req);

        if($formRev->isSubmitted()&& $formRev->isValid()) {

            $em->persist($p);
            $em->flush();
            
            dump($p);
            return $this->redirectToRoute('quizadd');
        }

        return  $this->render('Admin/quiz/show.html.twig', [
            
            'formajout' => $formRev->createView(),
            'quiz' => $repo->findAll(),
    
    
    ]);
    }





    //------------------edit quiz and show question ------------------------------



    #[Route('/quizDashEdit/{id}', name: 'quizedit')]
    public function editquiz( ManagerRegistry $manager, Request $req, QuizRepository $rep ,QuestionRepository $repo,$id,QuizRepository $repoqui ): Response
    {
        $em = $manager->getManager();
        $p = $rep->find($id);

        $formRev = $this->createform(QuizType::class, $p);

        $formRev->handleRequest($req);

        if (($formRev->isSubmitted()) && ($formRev->isValid()) ) {

            $em->persist($p);
            $em->flush();

            return $this->redirectToRoute('quizadd');
        }

        return  $this->render('Admin/quiz/edit.html.twig', [
            'formed' => $formRev->createView(),
            'question' => $repo->showquestionbyid($id),
            'idquiz'=>$id,
            'quiz' =>$p,

        ]);
    }






    //------------------delete quiz ------------------------------



    #[Route('/quizDashDelete/{id}', name: 'quizdelete')]
    public function deletequiz( ManagerRegistry $manager, Request $req, QuizRepository $rep ,$id,CertificationRepository $repo,QuestionRepository $quesrp): Response
    {
       $em=$manager->getManager();
       $repo->Deletecertifwehere($id);
       $quesrp->Deletequeswehere($id);

       $p=$rep->find($id);

          $em->remove($p);
          $em->flush();

          return $this->redirectToRoute('quizadd');
    }




    //--------------------------------------------------------------questions--------------------------------------------------------------------------------

    #[Route('/quizpass/{id}/{idquiz}', name: 'quizpass')]
    public function passquizt(QuizRepository $rep,$idquiz,$id ,QuestionRepository $repo): Response
    { 
         return  $this->render('User/quiz/quizpass.html.twig', [
            
            'questions' => $repo->showquestionbyid($idquiz),
            'quiz' => $rep->find($idquiz),
            'idquiz'=>$idquiz,

            

         ]);
            
    }
    //__________________________________________________________________answer____________________________________________

    #[Route('/check-answers/{id}/{idquiz}', name: 'check_answers', methods: ['POST'])]
public function checkAnswers(Request $request, QuestionRepository $questionRepository, $idquiz,$id, EntityManagerInterface $entityManager): Response
{
    // Retrieve form data from the request
    $selectedChoices = $request->request->all();

    // Get the total number of questions
    $questions = $questionRepository->showquestionbyid($idquiz);
    $totalQuestions = count($questions);

    // Initialize a variable to store the total correct answers
    $totalCorrectAnswers = 0;

    // Loop through each question and check if the selected choice is correct
    foreach ($questions as $index => $question) {
        $selectedChoice = $selectedChoices['answer-' . ($index + 1)];
        if ($selectedChoice == $question->getChoix1()) {
            $totalCorrectAnswers++;
        }
    }





    // Prepare the message containing the total correct answers
    $message = sprintf('You answered %d out of %d questions correctly.', $totalCorrectAnswers, $totalQuestions);


    if ($totalCorrectAnswers > 3) {
        // Create a new Certification entity
        $certification = new Certification();
        $certification->setQuiz($entityManager->getReference(Quiz::class, $idquiz)); // Assuming Quiz entity has a getById method
        $certification->setUser($entityManager->getReference(User::class, $id)); // Assuming you have user authentication set up
        $entityManager->persist($certification);
        $entityManager->flush();
        
        $message .= ' You have earned a certification.';
    }
    else{

        $message .= ' soory try again.';
    }

    // Return a response with the message
    return $this->json(['message' => $message]);
}
    
}
