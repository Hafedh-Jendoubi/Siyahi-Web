<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'list_user')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render("user/index.html.twig", array('tabUsers'=>$users));
    }

    #[Route('/addUser', name: 'addUser')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setRole("user");
            $em->flush();
            return $this->redirectToRoute("users");
        }
        return $this->renderForm("user/add.html.twig", array('formUser'=>$form));
    }

    #[Route('/removeUser/{id}', name: 'removeUser')]
    public function deleteAuthor(ManagerRegistry $managerRegistry, $id, UserRepository $repository)
    {
        $user = $repository->find($id);
        $em = $managerRegistry->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute("users");
    }
}
