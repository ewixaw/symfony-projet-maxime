<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\RealisateurType;
use App\Repository\RealisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/realisateur')]
final class RealisateurController extends AbstractController
{
    #[Route(name: 'app_realisateur_index', methods: ['GET'])] # Traite les connexions à /realisateur qui envoient un formulaire GET
    public function index(RealisateurRepository $realisateurRepository): Response
    {
        return $this->render('realisateur/index.html.twig', [
            'realisateurs' => $realisateurRepository->findAll(), # Envoie les informations des realisateurs pour leur affichage sur la page twig
        ]);
    }

    #[Route('/new', name: 'app_realisateur_new', methods: ['GET', 'POST'])] # Traite les connexions à /realisateur/new qui envoient un formulaire GET ou POST
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        # Gère le formulaire de création d'un réalisateur

        $realisateur = new Realisateur();
        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($realisateur); # Enregistre des données en local
            $entityManager->flush(); # Synchronise la BDD avec les données locales

            return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER); # En cas de formulaire valide redirige sur la page affichant tous les réalisateurs
        }

        # Si aucun formulaire envoyé alors affiche la page du formulaire avec les informations voulues
        return $this->render('realisateur/new.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_realisateur_show', methods: ['GET'])] # Traite les connexions à /realisateur/{id} qui envoient un formulaire GET
    public function show(Realisateur $realisateur): Response
    {
        return $this->render('realisateur/show.html.twig', [
            'realisateur' => $realisateur,  # Envoie les informations du realisateur pour leur affichage sur la page twig
        ]);
    }

    #[Route('/{id}/edit', name: 'app_realisateur_edit', methods: ['GET', 'POST'])] # Traite les connexions à /realisateur/{id}/edit qui envoient un formulaire GET ou POST
    public function edit(Request $request, Realisateur $realisateur, EntityManagerInterface $entityManager): Response
    {
        # Gère le formulaire d'édition d'un réalisateur

        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); # Synchronise la BDD avec les données locales

            return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        # Envoie les informations nécessaire au bon affichage du formulaire et des données du réalisateur pour leur édition
        return $this->render('realisateur/edit.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_realisateur_delete', methods: ['POST'])] # Traite les connexions à /realisateur/{id} qui envoient POST
    public function delete(Request $request, Realisateur $realisateur, EntityManagerInterface $entityManager): Response
    {
        # Gère la suppression d'un réalisation de la BDD

        if ($this->isCsrfTokenValid('delete'.$realisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($realisateur); # Supprime des données en local
            $entityManager->flush(); # Synchronise la BDD avec les données locales
        }

        return $this->redirectToRoute('app_realisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
