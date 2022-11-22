<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TaskType;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
   
    #[Route('/tasklist', name: 'task_list')]
    public function listTask(TaskRepository $taskRepository): Response
    {

        $tasks = $taskRepository->findBy([], ['createdAt' => 'asc'], );
        return $this->render('task/taskList.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
        ]);
    }
    #[Route('/createtask', name: 'task_create')]
    public function createAction(EntityManagerInterface $em, Request $request ): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTimeImmutable)
                ->setIsDone(false);
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('task/createtask.html.twig', [
            'form' => $form->createView()
        ])
        ;
    }
    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task, Request $request,EntityManagerInterface $em)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edittask.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task,EntityManagerInterface $em)
    {
        $task->setIsDone(!$task->getIsDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task,EntityManagerInterface $em)
    {
        
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}

