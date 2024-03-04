<?php

namespace App\Controller;

use App\Entity\DemandeAchat;
use App\Entity\Achat;
use App\Form\DemandeAchatType;
use App\Repository\DemandeAchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demandeachat')]
class DemandeAchatController extends AbstractController
{
    #[Route('/', name: 'app_demande_achat_index', methods: ['GET'])]
    public function index(DemandeAchatRepository $demandeAchatRepository): Response
    {
        return $this->render('demande_achat/index.html.twig', [
            'demande_achats' => $demandeAchatRepository->findAll(),
        ]);
    } 
    #[Route('/demandeachat/search', name: 'app_demande_achat_search', methods: ['GET'])]
    public function search(Request $request, DemandeAchatRepository $demandeAchatRepository): Response
    {
        // Récupération du terme de recherche depuis la requête
        $searchTerm = $request->query->get('search');

        // Recherche des demandes d'achat correspondant au terme de recherche
        $demandeAchats = $demandeAchatRepository->findBySearchTerm($searchTerm);

        // Affichage des résultats de recherche
        return $this->render('demande_achat/search_results.html.twig', [
            'demande_achats' => $demandeAchats,
        ]);
    }


    #[Route('/{idachat}/new', name: 'app_demande_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Achat $idachat): Response
    {
        $demandeAchat = new DemandeAchat();
        $demandeAchat->setAchat($idachat);
        $form = $this->createForm(DemandeAchatType::class, $demandeAchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeAchat);
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_achat/new.html.twig', [
            'demande_achat' => $demandeAchat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_achat_show', methods: ['GET'])]
    public function show(DemandeAchat $demandeAchat): Response
    {
        return $this->render('demande_achat/show.html.twig', [
            'demande_achat' => $demandeAchat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_achat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DemandeAchat $demandeAchat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeAchatType::class, $demandeAchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_achat/edit.html.twig', [
            'demande_achat' => $demandeAchat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_achat_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeAchat $demandeAchat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeAchat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demandeAchat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_achat_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/accepter', name: 'app_demande_achat_accepter', methods: ['GET', 'POST'])]
    public function accepter(Request $request, EntityManagerInterface $entityManager, $id): Response
    {   
        $demande = $entityManager->getRepository(DemandeAchat::class)->find($id);
        
        if (!$demande) {
            throw $this->createNotFoundException('La demande n\'existe pas.');
        }

        // Mettre à jour l'état de la demande
        $demande->setEtatdemande('demande accepter');

        $entityManager->flush();
       
        return $this->redirectToRoute('app_demande_achat_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/refuser', name: 'app_demande_achat_refuser', methods: ['GET', 'POST'])]
    public function refuser(Request $request, EntityManagerInterface $entityManager, $id): Response
    {   
        
        $demande = $entityManager->getRepository(DemandeAchat::class)->find($id);
        
        if (!$demande) {
            throw $this->createNotFoundException('La demande n\'existe pas.');
        }

        // Mettre à jour l'état de la demande
        $demande->setEtatdemande('demande refu');

        $entityManager->flush();
       
        return $this->redirectToRoute('app_demande_achat_index', [], Response::HTTP_SEE_OTHER);
    }
}
