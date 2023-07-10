<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    // ProjectRepository $repository
    #[Route('/projects', name: 'app_projects', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function show(ProjectRepository $repository): Response
    {
        // si le mot de passe est mauvais.
        // Current user
        // $user = $this->getUser();
        $projects = $repository->findAll();

        return $this->render('pages/projects.html.twig', [
            // 'user' => $user
            'projects' => $projects
        ]);
    }

    #[Route('/project/new', name: 'app_create_project', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(EntityManagerInterface $manager, Request $request): Response
    {
        // si le mot de passe est mauvais.
        // Current user
        $user = $this->getUser();
        // dd($user);
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $request = $form->handleRequest($request);
        $project->setOwner($user);

        
        if($form->isSubmitted() && $form->isValid()) {
            $projectInstance = $form->getData();
            $manager->persist($projectInstance);
            $manager->flush();
            
            return $this->redirectToRoute('app_projects');
        }

        return $this->render('pages/project/new.html.twig', [
            // 'user' => $user
            'form' => $form->createView()

        ]);
    }

    #[Route('/projects/{id}', name: 'app_single_project', methods: ['GET'])]
    public function single(TaskRepository $taskRepository, ProjectRepository $projectRepository, $id, EntityManagerInterface $manager): Response
    {
        $project = $projectRepository->find($id);
        // find all tasks which belongs to X's project
        $tasks = $taskRepository->findByProjectId($id);
       
        // $tasks = $taskRepository->findAll(['projectId' => $id]);
        $user = $this->getUser();

        // dd($tasks);

        return $this->render('pages\project\project.html.twig', [
            'controller_name' => 'ProjectController',
            'project' => $project,
            'tasks' => $tasks
        ]);
    }

    // #[Route('/projects/{id}/tasks', name: 'app_single_tasks', methods: ['GET'])]
    // public function single(ProjectRepository $repository, $id, EntityManagerInterface $manager): Response
    // {
    //     $project = $repository->find($id);
    //     $user = $this->getUser();

    //     return $this->render('pages\project\project.html.twig', [
    //         'controller_name' => 'ProjectController',
    //         'project' => $project,
    //     ]);
    // }

}