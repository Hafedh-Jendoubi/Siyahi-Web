<?php

namespace App\Controller;

use App\Entity\ReponseConge;
use App\Entity\User;
use App\Form\EditUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
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

    #[Route('/admin/users', name: 'admin_users')]
    public function listUsers(UserRepository $repository)
    {
        $users = $repository->findAll();

        return $this->render('user/users.html.twig', array('tabUsers' => $users));
    }

    #[Route('/staff/addUser', name: 'addUser')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setEmail(strtolower($user->getFirstName()) . "." . strtolower($user->getLastName()) . "@siyahi.tn");
            $hashedPassword = $passwordHasher->hashPassword($user, "0000");
            $user->setPassword($hashedPassword);
            if($user->getGender() == "M")
                $user->setImage("front/img/avatars/man.png");
            else
                $user->setImage("front/img/avatars/woman.png");
            $em->flush();
            return $this->redirectToRoute("addUser");
        }
        return $this->renderForm("user/add.html.twig", array('formUser'=>$form));
    }

    #[Route('/admin/removeUser/{id}', name: 'removeUser')]
    public function deleteUser(ManagerRegistry $managerRegistry, $id, UserRepository $repository)
    {
        $user = $repository->find($id);
        $em = $managerRegistry->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute("admin_users");
    }

    #[Route('/admin/updateUser/{id}', name: 'updateUser')]
    public function updateUser($id, UserRepository $repository, Request $request, ManagerRegistry $managerRegistry)
    {
        $user = $repository->find($id);
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $image = $form->get('image')->getData();
            var_dump($image);
            /*if ($image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                dump($image);
                $user->setImage('front/assets/img/team/' . $file);
            }*/
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }
        return $this->renderForm("user/updateUser.html.twig", array('formUser' => $form));
    }
}