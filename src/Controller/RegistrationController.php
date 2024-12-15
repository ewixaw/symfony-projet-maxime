<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')] # Traite toutes les connexions à /register
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_page'); # Si l'utilisateur est déjà connecté, le renvoie vers la page d'accueil du site
        }

        # La suite sert à gérer le formulaire d'enregistrement
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData(); # Récupère le mdp de l'utilisateur pour pouvoir le hasher

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword)); # Hash le mdp de l'utilisateur avant de l'enregistrer dans la BDD

            $entityManager->persist($user); # Enregistre des données en local
            $entityManager->flush(); # Synchronise la BDD avec les données locales

            return $security->login($user, UserAuthenticator::class, 'main'); # Connecte l'utilisateur à son compte
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
