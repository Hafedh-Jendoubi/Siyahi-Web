<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\ReponseCredit;
use App\Form\ReponseCredit1Type;
use App\Repository\CongeRepository;
use App\Repository\ReponseCreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function new(Request $request,Security $security , EntityManagerInterface $entityManager): Response
    {
        $reponseCredit = new ReponseCredit();
        $form = $this->createForm(ReponseCredit1Type::class, $reponseCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseCredit->setUser($security->getUser());
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
    public function show(int $id,ReponseCreditRepository $ReponseCreditRepository): Response
    {
        $reponseCredit = $ReponseCreditRepository->find($id);

        if (!$reponseCredit) {
            throw $this->createNotFoundException('La reponse demandé n\'existe pas');
        }

        return $this->render('reponse_credit/show.html.twig', [
            'reponse_credit' => $reponseCredit,
        ]);
    }
       


    #[Route('/{id}/edit', name: 'app_reponse_credit_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, int $id, ReponseCreditRepository $ReponseCreditRepository, EntityManagerInterface $entityManager): Response
{
    $ReponseCredit= $ReponseCreditRepository->find($id);

    if (!$ReponseCredit) {
        throw $this->createNotFoundException('Le congé demandé n\'existe pas');
    }

    $form = $this->createForm(ReponseCredit1Type::class, $ReponseCredit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_reponse_credit_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('reponse_credit/edit.html.twig', [
        'reponse_credit' => $ReponseCredit,
        'form' => $form,
    ]);
}

    
    #[Route('/{id}', name: 'app_reponse_credit_delete', methods: ['POST'])]
    public function deleteUser(ManagerRegistry $managerRegistry, $id, ReponseCreditRepository $ReponseCreditRepository)
    {
        $user = $ReponseCreditRepository->find($id);
        $em = $managerRegistry->getManager();
        $em->remove($user);
        $em->flush();
    
        return $this->redirectToRoute('app_reponse_credit_index');
    }

}
