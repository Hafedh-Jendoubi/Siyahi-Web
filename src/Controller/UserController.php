<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Entity\User;
use App\Form\EditUserType;
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

        return $this->render('user/index.html.twig');
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
            $em->flush();
            return $this->redirectToRoute("app_staff_section");
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

        return $this->redirectToRoute("admin_users");
    }

    #[Route('/updateUser/{id}', name: 'updateUser')]
    public function updateBook($id, UserRepository $repository, Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $user = $repository->find($id);
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }
        return $this->renderForm("admin/updateUser.html.twig", array('formUser' => $form));
    }
}