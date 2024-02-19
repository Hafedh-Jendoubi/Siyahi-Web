<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaffController extends AbstractController
{
    #[Route('/staff', name: 'app_staff')]
    public function index(): Response
    {
        return $this->render('staff/home.html.twig');
    }

    #[Route('/staff-section', name: 'app_staff_section')]
    public function staff_home()
    {
        return $this->render('staff/index.html.twig');
    }
}
