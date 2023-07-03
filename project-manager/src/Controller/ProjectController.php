<?php

namespace App\Controller;

// use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    // Pour gérer les erreurs, l'utiliosation dAuthenticationUtils utils
    #[Route('/', name: 'home_app', methods: ['GET'])]
    public function index(): Response
    {
        // si le mot de passe est mauvais.
        // $user = $this->user;
        return $this->render('pages/index.html.twig', [
            // 'user' => $user
        ]);
    }

    #[Route('/projects', name: 'projects_app', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function show(): Response
    {
        // si le mot de passe est mauvais.
        // $user = $this->user;
        return $this->render('pages/projects.html.twig', [
            // 'user' => $user
        ]);
    }


    
}