<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    #[Route('/', name: 'app_visitor')]
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig');
    }

    #[Route('/error', name: 'error')]
    public function Error_index()
    {
        return $this->render('visitor/error.html.twig');
    }
}
