<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use App\Repository\UserRepository;
use App\Service\YousignService;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf as Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
        $form1 = $this->createFormBuilder($liv)
        ->add('NomC')
        ->add('prenomC')
        ->add('email')
        ->add('PhoneN')
        ->add('State', ChoiceType::class, [
            'choices' => [
                'Tunisia' => 'Tunisia',
                'France' => 'France',
                'China' => 'China',
                'Germany' => 'Germany',
            ],
        ])
        ->add('adresse')
        ->add('TypePaiement', ChoiceType::class, [
            'choices' => [
                'Cash on delivery' => 'Cash on delivery',
            ],
        ])
        ->getForm();

    $form1->handleRequest($req);
        if ($form1 -> isSubmitted() && $form1->isValid()){
            $em->persist($liv) ;
            $em->flush() ;
            return $this->redirectToRoute('app_affUserSui');
        }
        return $this->renderForm('User/Livraison/livraison.html.twig',['form1'=>$form1]);
       
    }
    ////Affiche 
    #[Route('/afficheLiv', name: 'app_affLiv')]
    public function afficher(  LivraisonRepository $repos): Response
    {
        return $this->render('Admin/livraison/affiche.html.twig',
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
        return $this->renderForm('Admin/livraison/edit.html.twig',['form1'=>$form1]);
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
     
             return $this->render('Admin/livraison/showdetailLiv.html.twig', ['l' => $Livr]);
      
     }
     /////////////////////Order By

     #[Route(name:'byemail')]
     function Nom(LivraisonRepository $repo){
    
         $l=$repo->OrderName();
         return $this->render('Admin/affiche.html.twig', [
             'Livraisons' => $l,
         ]);
        }
       ////////////// ////trri par region

        #[Route('/dashboard', name: 'app_dashboard')]
        public function Trier (LivraisonRepository $rep): Response
        {
    
            $livreurs = $rep->countByRegion();
            $regionL = [];
            $countL = [];
            foreach ($livreurs as $liv) {
                $regionL[] = $liv['regionL'];
                $countL[] = $liv['countL'];
           }
    
            return $this->render('Admin/index.html.twig', [
                'controller_name' => 'NomController',
                'regionL' => json_encode($regionL),
                'countL' => json_encode($countL),
            ]);
        }

        ////////////////PDF
        #[Route('/PDF/{id}', name:'user_certif')]
    public function downloadcertif($id ,LivraisonRepository $repquiz)
    {
         // On définit les options du PDF
         $pdfOptions = new Options();
         // Police par défaut
         $pdfOptions->set('defaultFont', 'Arial');
         $pdfOptions->setIsRemoteEnabled(true);
 
         // On instancie Dompdf
         $dompdf = new Dompdf($pdfOptions);
         $context = stream_context_create([
             'ssl' => [
                 'verify_peer' => FALSE,
                 'verify_peer_name' => FALSE,
                 'allow_self_signed' => TRUE
             ]
         ]);
         $dompdf->setHttpContext($context);
 
         // On génère le html
         $html = $this->renderView('User/Livraison/PDF.html.twig', [

            'l' => $repquiz->find($id),


        ]);
 
         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();
 
         // On génère un nom de fichier
         $fichier = 'user-'.'.pdf';
 
         // On envoie le PDF au navigateur
         $dompdf->stream($fichier, [
             'Attachment' => true
         ]);
 
         return new Response();
    }
    //////////////////////Signature electronique
   
    ///////////// Affichage unique
    #[Route('/UserafficheSuiLiv', name: 'app_affUserSui')]
    public function afficherUser(  LivraisonRepository $repos ): Response
    {
        return $this->render('User/Livraison/LIV.html.twig',
            ['Livraisons' => $repos->findAll(),]);
    }
    
    /////////////map
      #[Route('/map', name: 'map')]
    public function map(): Response
    {
        return $this->render('map/index.html.twig');
    }


}
