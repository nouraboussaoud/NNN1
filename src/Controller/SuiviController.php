<?php

namespace App\Controller;

use App\Entity\SuiviLivraison;
use App\Form\SuiviType;
use App\Repository\LivraisonRepository;
use App\Repository\SuiviLivraisonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiviController extends AbstractController
{
    #[Route('/suivi', name: 'app_suivi')]
    public function index(): Response
    {
        return $this->render('admin/suivi/index.html.twig', [
            'controller_name' => 'SuiviController',
        ]);
    }
    ////Ajout
    #[Route('/addSuiLiv', name: 'app_add')]
    public function add(ManagerRegistry $manager ,Request $req): Response
    {
        $em = $manager-> getManager();//creation d'objet a partir l'entite
        $suiliv =new SuiviLivraison();
        $form1= $this->createForm(SuiviType::class , $suiliv);
        $form1->handleRequest($req) ;
        if ($form1 -> isSubmitted() && $form1->isValid()){
            $em->persist($suiliv) ;
            $em->flush() ;
            return $this->redirectToRoute('app_suivi');
        }
        return $this->renderForm('Admin/suivi/add.html.twig',['form1'=>$form1]);
       
    }
    ////affichage
    #[Route('/afficheSuiLiv', name: 'app_affSuiLiv')]
    public function afficher(  SuiviLivraisonRepository $repos): Response
    {
        return $this->render('Admin/suivi/afficheSuiLiv.html.twig',
            ['details' => $repos->findAll(),]);
    }
        ////modifier livraison
        #[Route('/editSuiLiv/{id}', name: 'app_editSuiLiv')]
        public function editBook(Request $request , ManagerRegistry $manager , $id ,SuiviLivraisonRepository $brep) :Response{
            $em=$manager->getManager();
            $Livr= $brep->find($id);
            $form1= $this->createForm(SuiviType::class ,$Livr);
            $form1->handleRequest($request);
            if($form1->isSubmitted()){
                $em->persist($Livr);
                $em->flush();
                return $this->redirectToRoute('app_affSuiLiv');
            }
            return $this->renderForm('Admin/suivi/edit.html.twig',['form1'=>$form1]);
        }
        ////Delete livraisonabout:
        #[Route('/deleteLiv/{id}', name: 'app_deleteSuiLiv')]
        public function deleteauthor(Request $request,ManagerRegistry $manager ,$id,SuiviLivraisonRepository $brep): Response
        {
            $em = $manager->getManager();
       
            $bToDel=$brep->find($id);
        
    
            $em->remove($bToDel);
            $em->flush();
            return $this->redirectToRoute('app_affSuiLiv');
    
        }
       

}
