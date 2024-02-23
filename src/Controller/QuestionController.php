<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }






 //----------------------------------------------- Show details ---------------------------------------------------------



    //----------------------------------------------- edit question ---------------------------------------------------------


    #[Route('/Question/details/{id}', name: 'quest_details')]
    public function editquest(Request $request, ManagerRegistry $manager, $id, QuestionRepository $quesrepository): Response
    {
        $em = $manager->getManager();
    
        // Retrieve the existing Question entity to edit
        $ques = $quesrepository->find($id);
    
        if (!$ques) {
            throw $this->createNotFoundException('Question not found');
        }
    
        // Create the form with the existing Question entity and preselected quiz
        $form = $this->createForm(QuestionType::class, $ques, [
            'preselected_quiz' => $ques->getQuiz(), // Pass the preselected quiz from the existing Question entity
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // No need to persist $ques again, as it's already managed by Doctrine
            $em->flush();
    
            // Redirect to the quiz edit page
            return $this->redirectToRoute('quest_details', ['id' => $id]);
        }
    
        return $this->renderForm('Admin/quiz/questdetails.html.twig', [
            'question' => $ques,
            'form' => $form,
        ]);
    }
    

//----------------------------------------------- add question ---------------------------------------------------------






#[Route('/questionDashadd/{idquiz}', name: 'questionadd')]
public function addquestion(ManagerRegistry $manager, Request $request, $idquiz, QuestionRepository $repo): Response
{
    $entityManager = $manager->getManager();

    $question = new Question();

    $preselectedQuiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idquiz);
    $form = $this->createForm(QuestionType::class, $question, [
        'preselected_quiz' => $preselectedQuiz,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the quiz for the question
        $question->setQuiz($preselectedQuiz);

        // Persist the question entity
        $entityManager->persist($question);
        $entityManager->flush();

        return $this->redirectToRoute('quizedit', ['id' => $idquiz]);
    }

    return $this->render('Admin/quiz/addquestion.html.twig', [
        'formajout' => $form->createView(),
    ]);
}

//----------------------------------------------- delete question ---------------------------------------------------------

#[Route('/questionDashDelete/{id}/{quizid}', name: 'questiondelete')]
public function deletequest( ManagerRegistry $manager, Request $req, QuestionRepository $rep ,$id,$quizid): Response
{
   $em=$manager->getManager();

   $p=$rep->find($id);

      $em->remove($p);
      $em->flush();

      return $this->redirectToRoute('quizedit',['id' => $quizid]);
}



}
