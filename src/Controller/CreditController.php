<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Form\Credit1Type;
use App\Repository\CreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as CoreSecurity;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/credit')]
class CreditController extends AbstractController
{
    #[Route('/', name: 'app_credit_index', methods: ['GET'])]
    public function index(Request $request, CreditRepository $creditRepository, CoreSecurity $security, PaginatorInterface $paginator): Response
    { //
        $user = $security->getUser();
        $pagination = $paginator->paginate(
            $creditRepository->findBy(['User' => $user]),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('credit/index.html.twig', [
            'credits' => $pagination,
        ]);
    }
    
    #[Route('/b', name: 'app_credit_indexb', methods: ['GET'])]
    public function indexb(Request $request, CreditRepository $creditRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $creditRepository->findAll(),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('credit/indexb.html.twig', [
            'credits' => $pagination,
        ]);
    }
    #[Route('/new', name: 'app_credit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CoreSecurity $security): Response
    {
        $credit = new Credit();
        $form = $this->createForm(Credit1Type::class, $credit);
        $form->handleRequest($request);
        
          

        if ($form->isSubmitted() && $form->isValid()) {
            $credit->setUser($security->getUser());
            $Contrat = $form->get('Contrat')->getData();
        if ($Contrat) {
            // Gérez le stockage du fichier
            $newFilename = uniqid().'.'.$Contrat->guessExtension();
            $Contrat->move(
                $this->getParameter('Credit_directory'),
                $newFilename
            );
            $credit->setContrat($newFilename);
        }
            $entityManager->persist($credit);
            $entityManager->flush();

            return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('credit/new.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }
     

    #[Route('/{id}', name: 'app_credit_show', methods: ['GET'])]
    public function show(int $id,CreditRepository $creditRepository): Response
    {
        $credit = $creditRepository->find($id);

    if (!$credit) {
        throw $this->createNotFoundException('Le credit demandé n\'existe pas');
    }
        return $this->render('credit/show.html.twig', [
            'credit' => $credit,
        ]);
    }
    #[Route('b/{id}', name: 'app_credit_showb', methods: ['GET'])]
    public function showb(int $id,CreditRepository $creditRepository): Response
    {
        $credit = $creditRepository->find($id);

    if (!$credit) {
        throw $this->createNotFoundException('Le credit demandé n\'existe pas');
    }
        return $this->render('credit/showb.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_credit_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, int $id, CreditRepository $CreditRepository, EntityManagerInterface $entityManager): Response
{
       $credit= $CreditRepository->find($id);
    if (!$credit) {
        throw $this->createNotFoundException('Le credit demandé n\'existe pas');
    }

    $form = $this->createForm(Credit1Type::class, $credit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $Contrat = $form->get('Contrat')->getData();

        if ($Contrat) {
            // Gérez le stockage du fichier
            $newFilename = uniqid().'.'.$Contrat->guessExtension();
            $Contrat->move(
                $this->getParameter('Credit_directory'),
                $newFilename
            );
            $credit->setContrat($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('credit/edit.html.twig', [
        'credit' => $credit,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_credit_delete', methods: ['POST'])]
public function deleteUser(ManagerRegistry $managerRegistry, $id, CreditRepository $CreditRepository)
{
    $user = $CreditRepository->find($id);
    $em = $managerRegistry->getManager();
    $em->remove($user);
    $em->flush();

    return $this->redirectToRoute('app_credit_index');
}
}
