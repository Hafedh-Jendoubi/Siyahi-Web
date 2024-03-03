<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\ReponseCredit;
use App\Form\ReponseCredit1Type;
use App\Repository\CongeRepository;
use App\Repository\CreditRepository;
use App\Repository\ReponseCreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as CoreSecurity;
use Knp\Component\Pager\PaginatorInterface;
use Twilio\Rest\Client;
use App\Service\TwilioService;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Swift_Mailer;
use Swift_Message;




#[Route('/reponse/credit')]
class ReponseCreditController extends AbstractController
{
    #[Route('/', name: 'app_reponse_credit_index', methods: ['GET'])]
    public function index(Request $request, CoreSecurity $security,  ReponseCreditRepository $reponseCreditRepository, PaginatorInterface $paginator): Response
    {
        $user = $security->getUser();
        $pagination = $paginator->paginate(
            $reponseCreditRepository->findBy(['User' => $user]),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('reponse_credit/index.html.twig', [
            'reponse_credits' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_reponse_credit_new', methods: ['GET', 'POST'])]
    public function new(MailerInterface $mailer,Request $request,CoreSecurity $security , EntityManagerInterface $entityManager): Response
    {
        $reponseCredit = new ReponseCredit();
        $form = $this->createForm(ReponseCredit1Type::class, $reponseCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponseCredit->setUser($security->getUser());
            $entityManager->persist($reponseCredit);
            $entityManager->flush();
            $this->addFlash('AddReponseCredit', 'Votre reponse_credit a été ajouté avec succès');

    
            $accountSid = 'ACd4df0fc05c27caa57a1852fe00965381';
            $authToken = 'dcf6eaf3135478e6b3d141daa2771e23';
            $client = new Client($accountSid, $authToken);
            $client->messages->create('+21658405717', // replace with admin's phone number // $message = $client->messages->create('+' . $form->get('tel')->getData(), // replace with admin's phone number

                [
                    'from' => '+12672824271', // replace with your Twilio phone number
                    'body' => 'Votre demande de credit a été traitée , Veuillez consulter notre site . Merci. ' ,
                ]
            ); 
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
        $this->addFlash('updateReponseCredit', 'Votre reponse_credit a été modifié avec succès');

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
        $this->addFlash('deleteReponseCredit', 'Votre reponse_credit a été supprimé avec succès');

        return $this->redirectToRoute('app_reponse_credit_index');
    }

}
