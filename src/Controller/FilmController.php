<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/film')] # Toutes les connexions à la page 127.0.0.1:8000/film/* sont traités ici
final class FilmController extends AbstractController
{
    #[Route(name: 'app_film_index', methods: ['GET'])] # Traite les connexions à la page /film qui envoient formulaire GET
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmRepository->findAll(), # Envoie les informations des films pour leur affichage sur la page twig
        ]);
    }

    #[Route('/new', name: 'app_film_new', methods: ['GET', 'POST'])] # Traite les connexions à la page /film/new qui envoient un formulaire GET ou POST
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        # Gère le formulaire de création d'un film

        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film); # Enregistre des données en local
            $entityManager->flush(); # Synchronise la BDD avec les données locales

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER); # En cas de formulaire valide redirige sur la page affichant tous les films
        }

        # Si aucun formulaire envoyé alors affiche la page du formulaire avec les informations voulues
        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])] # Traite les connexions à la page /film/{id} qui envoient un formulaire GET
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film, # Envoie les informations du film pour leur affichage sur la page twig
        ]);
    }

    #[Route('/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])] # Traite les connexions à la page /film/{id}/edit qui envoient un formulaire GET ou POST
    public function edit(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        # Gère le formulaire d'édition d'un film

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); # Synchronise la BDD avec les données locales

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        # Envoie les informations nécessaire au bon affichage du formulaire et des données du film pour leur édition
        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_delete', methods: ['POST'])] # Traite les connexions à la page /film/{id} qui envoient un formulaire POST
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        # Gère la suppression d'un film de la BDD

        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($film); # Supprime les données en local
            $entityManager->flush(); # Synchronise la BDD avec les données locales
        }

        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }
}
