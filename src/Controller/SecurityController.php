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
    #[Route(path:'/user/admin/{id}', name: 'role_admin')]
    public function AdminChange( User $user, EntityManagerInterface $em)
    {
        
        $user ->setRoles(['ROLE_ADMIN']);
        $em->flush();

        $this->addFlash('success', sprintf('La role de  %s a bien été modifié', $user->getEmail()));

        return $this->redirectToRoute('task_list');
        }
        #[Route(path:'/user/utilisateur/{id}', name: 'role_utilisateur')]
        public function UtilisateurChange( User $user, EntityManagerInterface $em)
        {
            
            $user ->setRoles(['ROLE_USER']);
            $em->flush();
    
            $this->addFlash('success', sprintf('La role de  %s a bien été modifié', $user->getEmail()));
    
            return $this->redirectToRoute('task_list');
            }
    
    #[Route(path:'/user/edit', name: 'user_edit')]
    public function editUser(UserRepository $userRepository, Request $request,EntityManagerInterface $em)
    {
        
       if (! $this->isGranted("USER_EDIT")) {
        return $this->redirectToRoute("app_home");
       }
        $user = $userRepository->findBy([], ['id' => 'asc'],);



            

        return $this->render('security/edituser.html.twig', [
            'controller_name' => 'SecurityController',
            'user' => $user,
        ]);
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
        
        //if ($user->getRoles() == null)  {
            $user->setRoles([$form->get('roles')->getData()]);
       // }
        $password = $form->get('password')->getData();
        $user->setPassword(($this->passwordHasher->hashPassword(
                $user,
                $password
        )))
             ;
             

        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'Votre inscription a bien été prise en compte');
        return $this->redirectToRoute('app_home');
    }


    return $this->render('security/registration.html.twig', [
        'form' => $form->createView()
    ]);
    
}}
