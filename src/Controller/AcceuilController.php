<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Form\CreditType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    #[Route('/addcredit', name: 'addcredit')]
    public function addCredit(Request $request, ManagerRegistry $managerRegistry)
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($credit);
            $entityManager->flush();
        }
    
        return $this->render("credit/Add.html.twig", ['form' => $form->createView()]);
    }
    


}
