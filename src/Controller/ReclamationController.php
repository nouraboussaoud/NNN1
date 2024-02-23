<?php

namespace App\Controller;



use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('User/reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }


    #[Route('/listRec', name: 'app_list')]
    public function afficher(ReclamationRepository $repos): Response
    {
       return $this->render('User/reclamation/affiche_list.html.twig',
       ['reclamations'=>$repos->findAll(),]);
    }


    #[Route('/add', name: 'app_adddynamique')]
    public function add(ManagerRegistry $manager,Request $req): Response
    {
        $em = $manager->getManager();

        $aut= new Reclamation();
       
        $form3A59 = $this->createForm(ReclamationType::class, $aut);

        $form3A59->handleRequest($req);
       
        if ($form3A59->isSubmitted()) {


            $em->persist($aut);
            $em->flush();

            return $this->redirectToRoute('app_list');
        }


        return $this->renderForm('User/reclamation/index.html.twig', ['form1' => $form3A59]);
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

    




}
