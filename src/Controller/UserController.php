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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function userFront(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user/index.html.twig', [
            'controller_name' => 'StaffController',
        ]);
    }

    #[Route('/users', name: 'list_user')]
    public function index(UserRepository $repository)
    {
        $users = $repository->findAll();

        return $this->render("user/list.html.twig", array('tabUsers'=>$users));
    }

    #[Route('/addUser', name: 'addUser')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setEmail($user->getLastName() . "." . $user->getFirstName() . "@siyahi.tn");
            $hashedPassword = $passwordHasher->hashPassword($user, "0000");
            $user->setPassword($hashedPassword);
            $user->setRoles(["ROLE_USER"]);
            $em->flush();
            return $this->redirectToRoute("list_user");
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

        return $this->redirectToRoute("list_user");
    }
}