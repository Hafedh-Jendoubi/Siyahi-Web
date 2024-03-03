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
        $sortableFields = ['id', 'service', 'rib', 'created_at', 'solde'];
    
        // Validate if the provided sortBy parameter is a valid sortable field
        if (!in_array($sortBy, $sortableFields)) {
            $sortBy = 'id'; // Default to 'id' if invalid sortBy parameter is provided
        }
    
        // Handle special cases for 'created_at', 'solde', and associations
        $sortParts = explode('.', $sortBy);
        $sortField = end($sortParts);
    
        // Check if it's an association
        if (count($sortParts) > 1) {
            $compteClients = $compteClientRepository->findByWithJoin([$sortField => $sortOrder], ['service']);
        } else {
            // Handle special cases for 'created_at' and 'solde'
            if ($sortField === 'created_at') {
                $compteClients = $compteClientRepository->findBy([], [$sortBy => $sortOrder]);
            } elseif ($sortField === 'solde') {
                $compteClients = $compteClientRepository->findBy([], [$sortBy => $sortOrder]);
            } else {
                $compteClients = $compteClientRepository->findBy([], [$sortBy => $sortOrder]);
            }
        }
    
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
        // Check if RIB already exists
        $existingCompteClient = $compteClientRepository->findOneBy(['rib' => $compteClient->getRib()]);

        if ($existingCompteClient) {
            // RIB already exists, handle accordingly (e.g., show an error message)
            // You might want to customize this part based on your needs
            $this->addFlash('error', 'This RIB already exists.');
            return $this->redirectToRoute('app_compte_client_new');
        }

        $entityManager->persist($compteClient);
        $entityManager->flush();

        return $this->redirectToRoute('app_compte_client_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('compte_client/new.html.twig', [
        'compte_client' => $compteClient,
        'form' => $form,
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