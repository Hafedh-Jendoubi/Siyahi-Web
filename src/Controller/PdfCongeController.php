<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfCongeController extends AbstractController
{
    #[Route('/pdf/conge', name: 'app_pdf_conge')]
    public function index(): Response
    {
        return $this->render('pdf_conge/index.html.twig', [
            'controller_name' => 'PdfCongeController',
        ]);
    }
}
