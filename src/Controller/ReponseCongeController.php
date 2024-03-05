<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Form\CongeReponseType;
use App\Entity\Conge;
use App\Repository\ReponseCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;



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
public function new(Request $request, EntityManagerInterface $entityManager, Security $security, MailerInterface $mailer): Response
{
    $reponseConge = new ReponseConge();
    $form = $this->createForm(CongeReponseType::class, $reponseConge);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reponseConge->setUser($security->getUser());
        $entityManager->persist($reponseConge);
        $entityManager->flush();

        // Construction du contenu de l'email
        $email = (new Email())
            ->from('bettaieb.ahmed@esprit.tn') // Remplacez par votre adresse email
            ->to('ahmedbettaib56@gmail.com') // Adresse email de votre compte Mailtrap
            ->subject('Nouvelle réponse de congé ajoutée')
            ->html('<p>Une nouvelle réponse de congé a été ajoutée.</p>');

        try {
            // Envoi de l'email
            $mailer->send($email);
            
            // Si l'email est envoyé avec succès, redirigez avec un message de succès
            $this->addFlash('success', 'L\'email a été envoyé avec succès.');
        } catch (TransportExceptionInterface $e) {
            // Si une erreur se produit lors de l'envoi de l'email, redirigez avec un message d'erreur
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'email : ' . $e->getMessage());
        }

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
#[Route('/{id}/confirm', name: 'app_reponse_conge_confirm', methods: ['POST'])]
    public function confirm(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $reponseConge = $entityManager->getRepository(ReponseConge::class)->find($id);

        if (!$reponseConge) {
            throw $this->createNotFoundException('La réponse de congé demandée n\'existe pas');
        }

        

        // Mettre à jour le statut de la demande de congé associée
        $conge = $reponseConge->getConge();
        if ($conge) {
            // Modifier le statut de la demande de congé
            $conge->setStatus(true);
            $entityManager->persist($conge);
            $entityManager->flush();
        }

    $entityManager->flush();
    return $this->redirectToRoute('app_reponse_conge_index', [], Response::HTTP_SEE_OTHER);
    

    // Redirigez ou affichez un message de confirmation
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

    #[Route('/pdf/{id}', name: 'app_reponse_conge_pdf')]
    public function generatePdf( int $id,ReponseCongeRepository $reponseCongeRepository): Response
    {
        $reponseConges = $reponseCongeRepository->find($id);
        $data = [
           
           
            'description'         => $reponseConges->getDescription(),
            'DateDebut'         => $reponseConges->getDateDebut(),
            'DateFin' => $reponseConges->getDateFin(),
            'Conge'      => $reponseConges->getConge(),
            
            
        ];
        

        // Création d'une instance Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Construction du contenu HTML du PDF
        $html =  $this->renderView('reponse_conge/pdf.html.twig', $data);

        // Chargement du contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Réglage du format du papier et du style (optionnel)
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Envoi du PDF en réponse
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
    
    #[Route('/calendar1', name: 'calendar')]
public function calendar(ManagerRegistry $doctrine): Response
{
    $evenements = $doctrine->getRepository(ReponseConge::class)->findAll();
    $rdvs = [];

    foreach ($evenements as $evenement) {
        $rdvs[] = [
            'id'          => $evenement->getId(),
            'title'       => $evenement->getDescription(), // Utiliser la description comme titre de l'événement
            'description' => 'Du ' . $evenement->getDateDebut()->format('Y-m-d') . ' au ' . $evenement->getDateFin()->format('Y-m-d'), // Description affichant la durée de congé
            'start'       => $evenement->getDateDebut()->format('Y-m-d'), // Utiliser la date de début
            'end'         => $evenement->getDateFin()->modify('+1 day')->format('Y-m-d'), // Utiliser la date de fin (+1 jour pour inclure la journée de fin)
        ];
    }

    $data = json_encode($rdvs);

    return $this->render('reponse_conge/calendar.html.twig', compact('data'));
}

}