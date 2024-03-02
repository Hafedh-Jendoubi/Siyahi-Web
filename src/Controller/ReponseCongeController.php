<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Form\CongeReponseType;
use App\Repository\ReponseCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;



#[Route('/reponse/conge')]
class ReponseCongeController extends AbstractController
{
    #[Route('/', name: 'app_reponse_conge_index', methods: ['GET'])]
    public function index(ReponseCongeRepository $reponseCongeRepository,Security $security): Response
    {
        $user = $security->getUser();

       
        
        return $this->render('reponse_conge/index.html.twig', [
            'reponse_conges' => $reponseCongeRepository->findBy(['User'=>$user]),
        ]);
    }

    #[Route('/new', name: 'app_reponse_conge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $reponseConge = new ReponseConge();
        $form = $this->createForm(CongeReponseType::class, $reponseConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseConge->setUser($security->getUser());
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
public function show(int $id, ReponseCongeRepository $reponseCongeRepository): Response
{
    $reponseConge = $reponseCongeRepository->find($id);

    if (!$reponseConge) {
        throw $this->createNotFoundException('La réponse de congé demandée n\'existe pas');
    }

    return $this->render('reponse_conge/show.html.twig', [
        'reponse_conge' => $reponseConge,
    ]);
}


#[Route('/{id}/edit', name: 'app_reponse_conge_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, int $id, ReponseCongeRepository $reponseCongeRepository, EntityManagerInterface $entityManager): Response
{
    $reponseConge = $reponseCongeRepository->find($id);

    if (!$reponseConge) {
        throw $this->createNotFoundException('La réponse de congé demandée n\'existe pas');
    }

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
public function delete(ManagerRegistry $managerRegistry, $id, ReponseCongeRepository $repository)
{
    $user = $repository->find($id);
    $em = $managerRegistry->getManager();
    $em->remove($user);
    $em->flush();

    return $this->redirectToRoute('app_reponse_conge_index');
}
}
