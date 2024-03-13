<?php

namespace App\Controller;


use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\PhoneNumber;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Notifier\Message\MessageInterface;


class ReclamationController extends AbstractController
{
    


    #[Route('/listRec', name: 'app_list')]
    public function afficher(ReclamationRepository $repos): Response
    {
        $reclamations = $repos->findAll();
        $preselecteduser = new User(); // Replace with your logic to get the preselected user

       return $this->render('User/reclamation/affiche_list.html.twig',
       ['reclamations'=>$repos->findAll(),]);
    }

    #[Route('/listRecTraite', name: 'app_list_Traite')]
    public function afficher_Traite(ReclamationRepository $repos): Response
    {
        $reclamations = $repos->findAll();
       return $this->render('User/reclamation/list_tratite.html.twig',
       ['reclamations'=>$repos->findAll(),]);
    }


    #[Route('/listRecNonTraite', name: 'app_list_NonTraite')]
    public function afficher_NonTraite(ReclamationRepository $repos): Response
    {
        $reclamations = $repos->findAll();
       return $this->render('User/reclamation/list_Non_Traite.html.twig',
       ['reclamations'=>$repos->findAll(),]);
    }
    

    #[Route('/add/{id}', name: 'app_adddynamique', methods: ['GET', 'POST'])]
    public function add(ManagerRegistry $manager, Request $req, $id): Response
    {
        $em = $manager->getManager();
    
        // Find the user by ID
        $preselecteduser = $this->getDoctrine()->getRepository(User::class)->find($id);
    
        if (!$preselecteduser) {
            // Handle the case when the user is not found
            throw $this->createNotFoundException('User not found');
        }
    
        $aut = new Reclamation();
        $aut->setEtat('Non traite');
    
        // Use the user data in the form
        $form3A59 = $this->createForm(ReclamationType::class, $aut, [
            'data_class' => Reclamation::class, // Make sure this is set correctly
            'preselected_user' => $preselecteduser,
        ]);
    
        $form3A59->handleRequest($req);
    
        if ($form3A59->isSubmitted() && $form3A59->isValid()) {
            // Set the user for the reclamation
            $aut->setUser($preselecteduser);
    
            if ($form3A59->get('imageFile')->getData() instanceof UploadedFile) {
                // Manage the image upload with VichUploaderBundle
                $aut->setImageFile($form3A59->get('imageFile')->getData());
            }
    
            $em->persist($aut);
            $em->flush();
    
            $this->addFlash('success', 'Your reclamation has been added successfully');
    
            return $this->redirectToRoute('app_list');
        }
    
        return $this->renderForm('User/reclamation/index.html.twig', ['form1' => $form3A59 ]);
    }
    


    #[Route('/edit/{id}', name: 'edit')]
    public function editrepas(Request $request, ManagerRegistry $manager, $id, ReclamationRepository $autrep): Response
    {
        $em = $manager->getManager();

        $autToEdit = $autrep->find($id);
        $form = $this->createForm(ReclamationType::class, $autToEdit);
       
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($autToEdit);
            $em->flush();
            return $this->redirectToRoute('app_list');
        }

        return $this->render('User/reclamation/edit_Rec.html.twig', [ 'reclamations' => $autToEdit,          
        'form1' => $form->createView(),
    ]);
    }


    #[Route('/delete/{id}', name: 'd')]
    public function delete(Request $request, $id, ManagerRegistry $manager, ReclamationRepository $autrep): Response
    {
        $em = $manager->getManager();
        $aut = $autrep->find($id);

        $em->remove($aut);
        $em->flush();

        return $this->redirectToRoute('app_list');
    }


    #[Route('/admin', name: 'app_admin')]
    public function admin(ReclamationRepository $reclamationRepository): Response
    {
        $aut = $reclamationRepository->findAll();

        return $this->render('Admin/Reclamation/reclamation_admin.html.twig', [
            'aut' => $aut,
            'controller_name' => 'ReclamationController',
        ]);
    
    }

   

    #[Route('/delete_Rec/{id}', name: 'd_admin')]
    public function delete_Rec_admin(Request $request, $id, ManagerRegistry $manager, ReclamationRepository $autrep): Response
    {
        $em = $manager->getManager();
        $aut = $autrep->find($id);

        if ($aut) {
            // Supprimer l'entité de la base de données
            $em->remove($aut);
            $em->flush();
    
            $this->addFlash('success', 'La réclamation a été supprimée avec succès.');
        } else {
            $this->addFlash('danger', 'Réclamation non trouvée.');
        }

        
        return $this->redirectToRoute('app_admin');
    }
    

    #[Route('/reclamation/{id}', name: 'user_reclamation_detail')]
    public function show(ReclamationRepository $reclamationRepository ,$id, ReponseRepository $reponseRepository): Response
    {
        $reclamation = $reclamationRepository->find($id);
        

        // Vérifiez si l'entité a été trouvée
        if (!$reclamation) {
            throw $this->createNotFoundException('Reclamation not found');
        }
        // else {
        //     $response = $reponseRepository->findBy(['rec'=>$reclamation->getId()]);
        //     return $this->render('User/reclamation/show_details.html.twig',[
        //         'reclamation' => $reclamation,
        //         'responses' => $response,
        //     ]);
        // }

        $respone = $reclamation->getRecRep();
        return $this->render('User/reclamation/show_details.html.twig', [
            'reclamation' => $reclamation,
            'responses' => $respone,
        ]);
    }

    
    #[Route('/reclamation_admin/{id}', name: 'admin_reclamation_detail')]
    public function show_admin(ReclamationRepository $reclamationRepository ,$id, ReponseRepository $reponseRepository): Response
    {
        $reclamation = $reclamationRepository->find($id);
        

        // Vérifiez si l'entité a été trouvée
        if (!$reclamation) {
            throw $this->createNotFoundException('Reclamation not found');
        }
        // else {
        //     $response = $reponseRepository->findBy(['rec'=>$reclamation->getId()]);
        //     return $this->render('User/reclamation/show_details.html.twig',[
        //         'reclamation' => $reclamation,
        //         'responses' => $response,
        //     ]);
        // }

        $respone = $reclamation->getRecRep();
        return $this->render('Admin/Reclamation/show_details_admin.html.twig', [
            'reclamation' => $reclamation,
            'responses' => $respone,
        ]);
    }

    #[Route('/statistics', name: 'app_statistics')]
    public function statistics(ReclamationRepository $reclamationRepository): Response
    {
        $categories = $reclamationRepository->getDistinctCategories();
        $totalReclamations = $reclamationRepository->countAll(); // Nouvelle méthode pour obtenir le total des réclamations

        $data = [];

        foreach ($categories as $category) {
            $count = $reclamationRepository->countByCategory($category);
            $percentage = ($totalReclamations > 0) ? ($count / $totalReclamations) * 100 : 0;
            $data[] = ['category' => $category, 'percentage' => $percentage];
        }

        return $this->render('Admin/Reclamation/statistic.html.twig', [
            'data' => json_encode($data),
        ]);
    }

 
#[Route('/search-reclamations', name: 'search_reclamations')]

public function searchReclamations(Request $request, ReclamationRepository $reclamationRepository): Response
{
    // Get the search term from the request
    $searchTerm = $request->request->get('search');

    // Add your logic to fetch search results based on $searchTerm
    $reclamations = $reclamationRepository->searchByCategory($searchTerm);

    // Render the search results in the search_results.html.twig template
    return $this->render('YourBundle/YourController/search_results.html.twig', ['reclamations' => $reclamations]);
}
   

    

}



    


