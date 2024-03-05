<?php

namespace App\Controller;

use App\Entity\CompteClient;
use App\Form\CompteClientType;
use App\Repository\CompteClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/compte/client')]
class CompteClientController extends AbstractController
{
    #[Route('/', name: 'app_compte_client_index', methods: ['GET'])]
    public function index(CompteClientRepository $compteClientRepository, Request $request): Response
    {
        $sortBy = $request->query->get('sortBy', 'id');
        $sortOrder = $request->query->get('sortOrder', 'asc');
    
        // Adjust the sorting fields based on your entity properties
        $sortableFields = ['id', 'service.name', 'rib', 'createdAt', 'Solde'];
    
        // Validate if the provided sortBy parameter is a valid sortable field
        if (!in_array($sortBy, $sortableFields)) {
            $sortBy = 'id'; // Default to 'id' if an invalid sortBy parameter is provided
        }
    
        // Handle special cases for 'createdAt' and 'service.name'
        if ($sortBy === 'createdAt') {
            $sortBy = 'created_at'; // Assuming the actual field name is 'created_at'
        } elseif ($sortBy === 'service.name') {
            $sortBy = 'service.name'; // Adjust based on your actual relationship
        } elseif ($sortBy === 'solde') {
            $sortBy = 'solde'; // Explicitly use 'solde' for sorting
        }
    
        $compteClients = $compteClientRepository->findBy([], [$sortBy => $sortOrder]);
    
        return $this->render('compte_client/index.html.twig', [
            'compte_clients' => $compteClients,
            'sortableFields' => $sortableFields,
            'currentSort' => ['field' => $sortBy, 'order' => $sortOrder],
        ]);
    }
    



    #[Route('/new', name: 'app_compte_client_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, CompteClientRepository $compteClientRepository): Response
{
    $compteClient = new CompteClient();
    $form = $this->createForm(CompteClientType::class, $compteClient);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Vérifier le solde en fonction du service choisi
        $service = $compteClient->getService()->getName();
        $solde = $compteClient->getSolde();

        // Vérifier les conditions pour les services Business et VIP
        if ($service === 'Business' && $solde <= 10000) {
            $this->addFlash('error', 'Le service Business nécessite un solde supérieur à 10000.');
            // Redirect back to the new page
            return $this->redirectToRoute('app_compte_client_new');
        } elseif ($service === 'VIP' && $solde <= 30000) {
            $this->addFlash('error', 'Le service VIP nécessite un solde supérieur à 30000.');
            // Redirect back to the new page
            return $this->redirectToRoute('app_compte_client_new');
        } else {
            // If all conditions are met, persist the entity
            $entityManager->persist($compteClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_client_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    // If any validation fails, stay on the same page and ask the user to correct the solde
    return $this->render('compte_client/new.html.twig', [
        'compte_client' => $compteClient,
        'form' => $form->createView(),
    ]);
}

    


    #[Route('/{id}', name: 'app_compte_client_show', methods: ['GET'])]
    public function show(CompteClient $compteClient): Response
    {
        return $this->render('compte_client/show.html.twig', [
            'compte_client' => $compteClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_compte_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompteClient $compteClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteClientType::class, $compteClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('compte_client/edit.html.twig', [
            'compte_client' => $compteClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_client_delete', methods: ['POST'])]
    public function delete(Request $request, CompteClient $compteClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compteClient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($compteClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_client_index', [], Response::HTTP_SEE_OTHER);
    }
}