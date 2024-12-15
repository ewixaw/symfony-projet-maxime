<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('/home/page', name: 'app_home_page')] # Traites toutes les connexions à /home/page et renvoie aux pages de login/enregistrement si l'utilisateur n'est pas connecté
    public function index(): Response
    {
        # Vérifie si l'utilisateur est connecté, le renvoie sur la page de login si non, sinon le laisse acceder à la page d'accueil

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home_page/index.html.twig');
    }
}
