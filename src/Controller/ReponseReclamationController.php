<?php

namespace App\Controller;

use App\Entity\ReponseReclamation;
use App\Form\ReponseReclamationType;
use App\Repository\ReponseReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation; // Ajoutez cette ligne


#[Route('/reponse/reclamation')]
class ReponseReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reponse_reclamation_index', methods: ['GET'])]
    public function index(ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        return $this->render('reponse_reclamation/index.html.twig', [
            'reponse_reclamations' => $reponseReclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponseReclamation = new ReponseReclamation();
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseReclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_reclamation_show', methods: ['GET'])]
    public function show(ReponseReclamation $reponseReclamation): Response
    {
        return $this->render('reponse_reclamation/show.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reponse_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/edit.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseReclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponseReclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    // Exemple dans votre contrôleur

// Exemple dans votre contrôleur
public function addReponseToReclamation(Reclamation $reclamation, ReponseReclamation $reponse, EntityManagerInterface $entityManager)
{
    // Ajoutez la réponse à la réclamation
    $reclamation->addReponseReclamation($reponse);

    // Mettez à jour le statut de la réclamation
    $reclamation->updateStatus();

    // Enregistrez les modifications dans la base de données
    $entityManager->persist($reclamation);
    $entityManager->flush();

    // ... Autres logiques de redirection ou de réponse
}


}
