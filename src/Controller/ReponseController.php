<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }


    #[Route('/listRep', name: 'app_list_Rep')]
    public function afficher(ReponseRepository $repos): Response
    {
       return $this->render('Admin/reponse/afficher_reponse.html.twig',
       ['reponses'=>$repos->findAll(),]);
    }


    #[Route('/add_Rep', name: 'app_addRep')]
    public function add_Rep(ManagerRegistry $manager,Request $req): Response
    {
        $em = $manager->getManager();

        $Rep= new Reponse();
       
        $form3 = $this->createForm(ReponseType::class, $Rep);

        $form3->handleRequest($req);
       
        if ($form3->isSubmitted()) {

            $em->persist($Rep);
            $em->flush();

            return $this->redirectToRoute('app_list_Rep');
        }

        return $this->renderForm('Admin/reponse/Add_rep.html.twig', ['form2' => $form3]);
    }

    
    #[Route('/edit_Rep/{id}', name: 'Edit_Rep')]
    public function editrepas(Request $request, ManagerRegistry $manager, $id, ReponseRepository $autrep): Response
    {
        $em = $manager->getManager();

        $autToEdit = $autrep->find($id);
        $form = $this->createForm(ReponseType::class, $autToEdit);
       
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($autToEdit);
            $em->flush();
            return $this->redirectToRoute('app_list_Rep');
        }

        return $this->render('Admin/reponse/Edit_rep.html.twig', [  'reponses' => $autToEdit,       
        'form2' => $form->createView(),
    ]);

    }




    #[Route('/delete_reponse/{id}', name: 'delete')]
    public function delete_reponse(Request $request, $id, ManagerRegistry $manager, ReponseRepository $autrep): Response
    {
        $em = $manager->getManager();
        $aut = $autrep->find($id);

        $em->remove($aut);
        $em->flush();

        return $this->redirectToRoute('app_list_Rep');
    }


}
