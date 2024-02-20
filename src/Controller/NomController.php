<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NomController extends AbstractController
{
    #[Route('/home', name: 'app_nom')]
    public function index(): Response
    {
        return $this->render('nour/index.html.twig', [
            'controller_name' => 'NomController',
        ]);
    }
    ////Ajout
    #[Route('/addLiv', name: 'app_adddynamique')]
    public function add(ManagerRegistry $manager ,Request $req): Response
    {
        $em = $manager-> getManager();//creation d'objet a partir l'entite
        $liv =new Livraison();
        $form1= $this->createForm(LivraisonType::class , $liv);
        $form1->handleRequest($req) ;
        if ($form1 -> isSubmitted() && $form1->isValid()){
            $em->persist($liv) ;
            $em->flush() ;
            return $this->redirectToRoute('app_nom');
        }
        return $this->renderForm('User/Livraison/livraison.html.twig',['form1'=>$form1]);
       
    }
    #[Route('/afficheLiv', name: 'app_affLiv')]
    public function afficher(  LivraisonRepository $repos): Response
    {
        return $this->render('Admin/affiche.html.twig',
            ['Livraisons' => $repos->findAll(),]);
    }
    ////modifier livraison
    #[Route('/editLiv/{id}', name: 'app_editLiv')]
    public function editBook(Request $request , ManagerRegistry $manager , $id ,LivraisonRepository $brep) :Response{
        $em=$manager->getManager();
        $Livr= $brep->find($id);
        $form1= $this->createForm(LivraisonType::class ,$Livr);
        $form1->handleRequest($request);
        if($form1->isSubmitted()){
            $em->persist($Livr);
            $em->flush();
            return $this->redirectToRoute('app_affLiv');
        }
        return $this->renderForm('Admin/edit.html.twig',['form1'=>$form1]);
    }
    ////Delete livraisonabout:
    #[Route('/deleteLiv/{id}', name: 'app_deleteLiv')]
    public function deleteauthor(Request $request,ManagerRegistry $manager ,$id,LivraisonRepository $brep): Response
    {
        $em = $manager->getManager();
   
        $bToDel=$brep->find($id);
    

        $em->remove($bToDel);
        $em->flush();
        return $this->redirectToRoute('app_affLiv');

    }
    ///Show details

     #[Route('/showLiv/{id}', name: 'showLiv')]
     public function showbook(LivraisonRepository $repository ,$id)
     {
        
             $Livr = $repository->find($id);
             if (!$Livr) {
                 return $this->redirectToRoute('app_affLiv');
             }
     
             return $this->render('Admin/showdetailLiv.html.twig', ['l' => $Livr]);
      
     }
     #[Route(name:'byemail')]
     function Nom(LivraisonRepository $repo){
    
         $l=$repo->OrderLivByEmail();
         return $this->render('Admin/affiche.html.twig', [
             'Livraisons' => $l,
         ]);
        }

}
