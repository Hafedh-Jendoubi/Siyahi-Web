<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\SearchUserType;
use App\Form\UpdateUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
    public function listUsers(UserRepository $repository, Request $request)
    {
        $users = $repository->findAll();
        $form= $this->createForm(SearchUserType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $name= $form->getData()->getFirstName();
            return $this->render('user/users.html.twig', array('tabUsers' => $users, 'users' => $repository->searchUser($name), 'searchForm'=>$form->createView()));
        }

        return $this->render('user/users.html.twig', array('tabUsers' => $users, 'searchForm'=>$form->createView()));
    }

    public static function generate(int $length = 8): string
    {
        $characters = implode('', array_merge(
            range('a', 'z'),
            range('A', 'Z'),
            range(0, 9)
        ));

        $randomString = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $max)];
        }

        return $randomString;
    }

    #[Route('/staff/addUser', name: 'addUser')]
    public function addUser(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setEmail(strtolower($user->getFirstName()) . "." . strtolower($user->getLastName()) . "@siyahi.tn");
            $pass = self::generate();
            $hashedPassword = $passwordHasher->hashPassword($user, $pass);
            $user->setPassword($hashedPassword);
            if($user->getGender() == "M")
                $user->setImage("7f9183c93cb4803aefc8262447c4efc9.png");
            else
                $user->setImage("b56ef85920323ead69e5f0d1ca13a0cd.png");
            $user->setActivity('T');
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@siyahi.tn'))
                ->to($user->getOldEmail())
                ->subject('Account Creation')
                ->htmlTemplate('user/email.html.twig')
                ->context([
                    'SiyahiEmail' => $user->getEmail(),
                    'Password' => $pass
                ])
            ;
            $mailer->send($email);
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
            if ($image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                dump($image);

                $user->setImage($fichier);
            }
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }
        return $this->renderForm("user/updateUser.html.twig", array('formUser' => $form));
    }

    #[Route('/edit/{id}', name: 'editUser')]
    public function editMyProfile($id, UserRepository $repository, Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $auth_user = $this->getUser();
        $user_details = $repository->findOneByEmail($auth_user->getUserIdentifier());
        if($id == $user_details[0]->getId()){
            $user = $repository->find($id);
            $form = $this->createForm(UpdateUserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $managerRegistry->getManager();
                $image = $form->get('image')->getData();
                if ($image) {
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    dump($image);
                    $user->setImage($fichier);
                }
                $encodedPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );

                $user->setPassword($encodedPassword);
                $em->flush();
                return $this->redirectToRoute("user_account", ['id' => $id]);
            }
            return $this->renderForm("user/edit.html.twig", array('user' => $user, 'formUser' => $form));
        }else
            return $this->renderForm("visitor/error.html.twig");
    }

    #[Route('/account/{id}', name: 'user_account')]
    public function UserInfo($id, UserRepository $repository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser(); //$user has the logged in user
        $user_details = $repository->findOneByEmail($user->getUserIdentifier()); //$user_details got the details of the logged in user
        if ($user_details[0]->getRoles()[0] != "ROLE_ADMIN" && $user_details[0]->getRoles()[0] != "ROLE_SUPER_ADMIN") {
            if ($id == $user_details[0]->getId()) //It makes sure that you can't have access to other users account details
                return $this->renderForm("user/infoUser.html.twig", array('user' => $user));
            else
                return $this->renderForm("visitor/error.html.twig");
        } else {
            $user1 = $repository->find($id);
            return $this->renderForm("user/infoUser.html.twig", array('user' => $user1));
        }
    }

    #[Route('/admin/disable/{id}', name: 'disable_user_account')]
    public function disableUser($id, UserRepository $repository, ManagerRegistry $managerRegistry)
    {
        $user = $repository->find($id);
        $user->setActivity("F");
        $em = $managerRegistry->getManager();
        $em->flush();

        return $this->redirectToRoute("admin_users");
    }

    #[Route('/admin/enable/{id}', name: 'enable_user_account')]
    public function enableUser($id, UserRepository $repository, ManagerRegistry $managerRegistry)
    {
        $user = $repository->find($id);
        $user->setActivity("T");
        $em = $managerRegistry->getManager();
        $em->flush();

        return $this->redirectToRoute("admin_users");
    }

    #[Route('/admin/chart', name: 'users_chart')]
    public function userStatistics(UserRepository $repository): Response
    {


        return $this->render('user/chart.html.twig');
    }
    #[Route('/admin/chart', name: 'users_chart1')]
    public function userStatistics3(UserRepository $repository): Response
    {


        return $this->render('user/chart.html.twig');
    }
}