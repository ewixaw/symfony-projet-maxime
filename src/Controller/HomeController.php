<?php

namespace App\Controller;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')] # Traite toutes les connexions à la page 127.0.0.1:8000
    public function index(): Response
    {
        # Vérifie si l'utilisateur est connecté, le renvoie sur la page d'accueil du site si oui, sinon sur la page de login

        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            return $this->redirect('/login'); 
        }
        return $this->redirectToRoute('app_home_page');
    }
}
