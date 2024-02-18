<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Form\CongeReponseType;
use App\Repository\ReponseCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse/conge')]
class ReponseCongeController extends AbstractController
{
    #[Route('/', name: 'app_reponse_conge_index', methods: ['GET'])]
    public function index(ReponseCongeRepository $reponseCongeRepository): Response
    {
        return $this->render('reponse_conge/index.html.twig', [
            'reponse_conges' => $reponseCongeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reponse_conge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponseConge = new ReponseConge();
        $form = $this->createForm(CongeReponseType::class, $reponseConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseConge);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_conge/new.html.twig', [
            'reponse_conge' => $reponseConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_conge_show', methods: ['GET'])]
    public function show(ReponseConge $reponseConge): Response
    {
        return $this->render('reponse_conge/show.html.twig', [
            'reponse_conge' => $reponseConge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reponse_conge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseConge $reponseConge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CongeReponseType::class, $reponseConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_conge/edit.html.twig', [
            'reponse_conge' => $reponseConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_conge_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseConge $reponseConge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseConge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponseConge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_conge_index', [], Response::HTTP_SEE_OTHER);
    }
}
