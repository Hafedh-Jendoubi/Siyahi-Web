<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function listUsers(UserRepository $repository)
    {
        $users = $repository->findAll();

        return $this->render('admin/users.html.twig', array('tabUsers' => $users));
    }
}
