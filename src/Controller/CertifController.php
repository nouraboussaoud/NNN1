<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Form\CertifType;
use App\Repository\CertificationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CertifController extends AbstractController
{
    #[Route('/certif', name: 'app_certif')]
    public function index(): Response
    {
        return $this->render('certif/index.html.twig', [
            'controller_name' => 'CertifController',
        ]);
    }

    //----------------------------------------show certif -----------------------------------------------

    #[Route('/certifDasha', name: 'certifshow')]
    public function showquiz(CertificationRepository $rep): Response
    { {
            return $this->render(
                'Admin/quiz/certif.html.twig',
                ['certifs' => $rep->findAll(),]
            );
        }
    }

//-------------------------------------------add certif -----------------------------------------------------------

    #[Route('/addcertifDash', name: 'certifadd')]
    public function addquiz( ManagerRegistry $manager, Request $req, CertificationRepository $repo): Response
    {
        $em=$manager->getManager();

        $p=new Certification();
        $formRev = $this->createform(CertifType::class,$p);

        $formRev->handleRequest($req);

        if($formRev->isSubmitted()&& ($formRev->isValid())) {

            $em->persist($p);
            $em->flush();

            return $this->redirectToRoute('certifshow');
        }

        return  $this->render('Admin/quiz/addcertif.html.twig', [
            
            'formajout' => $formRev->createView(),
            
    
    
    ]);
    }



//--------------------------------------------------delete certif ------------------------------------------------------


    #[Route('/certifdelete/{id}', name: 'certifdelete')]
public function deletequest( ManagerRegistry $manager, Request $req,CertificationRepository $rep ,$id): Response
{
   $em=$manager->getManager();

   $p=$rep->find($id);

      $em->remove($p);
      $em->flush();

      return $this->redirectToRoute('certifshow');
}
}
