<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/projects/{id}')]
class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'create_task')]
    public function index($id, Request $request, ProjectRepository $projectRepository, TaskRepository $repository, EntityManagerInterface $manager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $request = $form->handleRequest($request);

        $user = $this->getUser();
        $task->setCreatedBy($user);

        $project = $projectRepository->findProjectById($id);
        $task->setProject($project);
        
        if($form->isSubmitted() && $form->isValid()) {
            $taskInstance = $form->getData();
            $manager->persist($taskInstance);
            $manager->flush();
            // dd($task);
            
            return $this->redirectToRoute('app_single_project',  ['id' => $id]);
        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/task/{taskId}', name: 'task_details')]
    public function single(TaskRepository $repository, Request $request, int $taskId, $id): Response
    {
        $task = $repository->find($taskId);

        return $this->render('task/task.html.twig', [
            'controller_name' => 'Task Controller',
            'task' => $task,
            'projectId'=> $id
        ]);
    }
}
