<?php

namespace App\Controller;

use App\Entity\ReponseCredit;
use App\Form\ReponseCredit1Type;
use App\Repository\ReponseCreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse/credit')]
class ReponseCreditController extends AbstractController
{
    #[Route('/', name: 'app_reponse_credit_index', methods: ['GET'])]
    public function index(ReponseCreditRepository $reponseCreditRepository): Response
    {
        return $this->render('reponse_credit/index.html.twig', [
            'reponse_credits' => $reponseCreditRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reponse_credit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponseCredit = new ReponseCredit();
        $form = $this->createForm(ReponseCredit1Type::class, $reponseCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseCredit);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_credit/new.html.twig', [
            'reponse_credit' => $reponseCredit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_credit_show', methods: ['GET'])]
    public function show(ReponseCredit $reponseCredit): Response
    {
        return $this->render('reponse_credit/show.html.twig', [
            'reponse_credit' => $reponseCredit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reponse_credit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseCredit $reponseCredit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseCredit1Type::class, $reponseCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_credit/edit.html.twig', [
            'reponse_credit' => $reponseCredit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_credit_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseCredit $reponseCredit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseCredit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponseCredit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_credit_index', [], Response::HTTP_SEE_OTHER);
    }
}
