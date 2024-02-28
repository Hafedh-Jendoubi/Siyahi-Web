<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Entity\ReponseConge;
use App\Form\Conge1Type;
use App\Repository\CongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as CoreSecurity;

#[Route('/conge')]
class CongeController extends AbstractController
{

     #[ Route("/search", name:"search")]
     
    public function search(Request $request, CongeRepository $congeRepository): Response
    {
        $email = $request->query->get('email');

        if ($email) {
            $conges = $congeRepository->searchByKeyword($email);
        } else {
            $conges = [];
        }

        return $this->render('conge/search_results.html.twig', [
            'conges' => $conges,
            'email' => $email,
        ]);
    }
    #[Route('/', name: 'app_conge_index', methods: ['GET'])]
    public function index(CongeRepository $congeRepository,CoreSecurity $security): Response
    {
        $user = $security->getUser();

       
        
        return $this->render('conge/index.html.twig', [
            'conges' => $congeRepository->findBy(['User'=>$user]),
        ]);
    }
    #[Route('/i', name: 'app_conge_indexb', methods: ['GET'])]
    public function index1(CongeRepository $congeRepository): Response
    {
        
        return $this->render('conge/indexback.html.twig', [
            'conges' => $congeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_conge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CoreSecurity $security): Response
    {
        $conge = new Conge();
        $form = $this->createForm(Conge1Type::class, $conge);
        $form->handleRequest($request);
        
          

        if ($form->isSubmitted() && $form->isValid()) {
            $conge->setUser($security->getUser());
            $justificationFile = $form->get('Justification')->getData();
        if ($justificationFile) {
            // Gérez le stockage du fichier
            $newFilename = uniqid().'.'.$justificationFile->guessExtension();
            $justificationFile->move(
                $this->getParameter('conge_directory'),
                $newFilename
            );
            $conge->setJustification($newFilename);
        }
            $entityManager->persist($conge);
            $entityManager->flush();

            return $this->redirectToRoute('app_conge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conge/new.html.twig', [
            'conge' => $conge,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_conge_show', methods: ['GET'])]
public function show(int $id, CongeRepository $congeRepository): Response
{
    $conge = $congeRepository->find($id);

    if (!$conge) {
        throw $this->createNotFoundException('Le congé demandé n\'existe pas');
    }

    return $this->render('conge/show.html.twig', [
        'conge' => $conge,
    ]);
}
#[Route('/i/{id}', name: 'app_conge_show1', methods: ['GET'])]
public function show1(int $id, CongeRepository $congeRepository): Response
{
    $conge = $congeRepository->find($id);

    if (!$conge) {
        throw $this->createNotFoundException('Le congé demandé n\'existe pas');
    }

    return $this->render('conge/showback.html.twig', [
        'conge' => $conge,
    ]);
}

    

#[Route('/{id}/edit', name: 'app_conge_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, int $id, CongeRepository $congeRepository, EntityManagerInterface $entityManager): Response
{
    $conge = $congeRepository->find($id);

    if (!$conge) {
        throw $this->createNotFoundException('Le congé demandé n\'existe pas');
    }

    $form = $this->createForm(Conge1Type::class, $conge);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $justificationFile = $form->get('Justification')->getData();

        if ($justificationFile) {
            // Gérez le stockage du fichier
            $newFilename = uniqid().'.'.$justificationFile->guessExtension();
            $justificationFile->move(
                $this->getParameter('conge_directory'),
                $newFilename
            );
            $conge->setJustification($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_conge_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('conge/edit.html.twig', [
        'conge' => $conge,
        'form' => $form,
    ]);
}





#[Route('/conge/{id}', name: 'app_conge_delete', methods: ['POST'])]
public function delete(Request $request, int $id, EntityManagerInterface $entityManager, CongeRepository $congeRepository): Response
{
    $conge = $congeRepository->find($id);

    if (!$conge) {
        throw $this->createNotFoundException('La demande de congé n\'existe pas.');
    }

    if ($this->isCsrfTokenValid('delete'.$conge->getId(), $request->request->get('_token'))) {
        $entityManager->remove($conge);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_conge_index');
}
 
    
}