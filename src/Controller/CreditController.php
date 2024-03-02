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
    {
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
        $sortBy = $request->query->get('sortBy');
        if ($sortBy === 'montant') {
            $pagination = $paginator->paginate(
            $creditRepository->findSortedByMontant(),
            $request->query->getInt('page', 1),
            4
        );
        } elseif ($sortBy === 'date') {
            $pagination = $paginator->paginate(
             $creditRepository->findSortedByDate(),
             $request->query->getInt('page', 1),
             4
         );
        } else {
            $pagination = $paginator->paginate(
                $creditRepository->findAll(),
                $request->query->getInt('page', 1),
                4
            );
        }

       

        return $this->render('credit/indexb.html.twig', [
            'credits' => $pagination,
        ]);
    }

    #[Route('/{id}', name: 'app_credit_show', methods: ['GET'])]
    public function show(string $id, CreditRepository $creditRepository): Response
    {
        $credit = $creditRepository->find($id);

       
        return $this->render('credit/show.html.twig', [
            'credit' => $credit,
        ]);
    }
   
    #[Route('b/{id}', name: 'app_credit_showb', methods: ['GET'])]
    public function showb(int $id, CreditRepository $creditRepository): Response
    {
        $credit = $creditRepository->find($id);

        if (!$credit) {
            throw $this->createNotFoundException('Le crédit demandé n\'existe pas');
        }

        return $this->render('credit/showb.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_credit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, CreditRepository $creditRepository, EntityManagerInterface $entityManager): Response
    {
        $credit = $creditRepository->find($id);
        if (!$credit) {
            throw $this->createNotFoundException('Le crédit demandé n\'existe pas');
        }

        $form = $this->createForm(Credit1Type::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Contrat = $form->get('Contrat')->getData();

            if ($Contrat) {
                $newFilename = uniqid().'.'.$Contrat->guessExtension();
                $Contrat->move(
                    $this->getParameter('Credit_directory'),
                    $newFilename
                );
                $credit->setContrat($newFilename);
            }

            $entityManager->flush();
            $this->addFlash('updateCredit', 'Votre crédit a été modifié avec succès');

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
        $this->addFlash('deleteCredit', 'Votre crédit a été supprimé avec succès');
        return $this->redirectToRoute('app_credit_index');
    } 

    #[Route('/credits/statistics3', name: 'credit_statistics3')]
    public function statistics3(CreditRepository $creditRepository): Response
    {
        $statistics = $creditRepository->getCreditStatistics();
        $credits = $creditRepository->findAllCredits();

        $creditsByYear = [];
        foreach ($credits as $credit) {
            $year = $credit->getDateDebutPaiement()->format('Y');
            if (!isset($creditsByYear[$year])) {
                $creditsByYear[$year] = 0;
            }
            $creditsByYear[$year]++;
        }

        return $this->render('credit/statistics2.html.twig', [
            'statistics' => $statistics,
            'creditsByYear' => $creditsByYear,
        ]);
    }

    #[Route('/filtreP', name: 'app_filtre')]
    public function filtre(CreditRepository $creditRepository, Request $request, ManagerRegistry $em, PaginatorInterface $paginator)
    {
        $minSolde = $request->query->get('minSolde');
        $maxSolde = $request->query->get('maxSolde');

        $credit = $creditRepository->findByPriceRange($minSolde, $maxSolde);
        $data = $paginator->paginate(
            $credit,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('credit/indexb.html.twig', [
            'credit' => $credit,
            'data' => $data
        ]);
    }
}
