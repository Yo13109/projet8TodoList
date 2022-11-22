<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationType;


class SecurityController extends AbstractController
{
    public function __construct(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
           return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/inscription', name: 'app_registration')]
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
    $user = new User;
    $form = $this->createForm(RegistrationType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $password = $form->get('password')->getData();
        $user->setPassword(($this->passwordHasher->hashPassword(
                $user,
                $password
            )));



        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }


    return $this->render('security/registration.html.twig', [
        'form' => $form->createView()
    ]);
}}
