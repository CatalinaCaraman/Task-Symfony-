<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TaskRepository;
use App\Entity\Task;
use App\Entity\Category;
use App\Form\TaskType;
use App\Service\TaskService;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ["GET"])]
    public function list(TaskService $taskService): Response
    {
        $tasks = $taskService->getAllTasks();

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/view/{id}', name: 'view')]
    public function view(int $id, TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }

        return $this->render('task/view.html.twig', [
            'task' => $task,
        ]);
    }
    #[Route('/task', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('t/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/create', name: 'app_task_create', methods: ["GET", "POST"])]
    public function create(Request $request, TaskService $taskService): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'Access Denied for You');
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('task/index.html.twig', [
                'form' => $form,
            ]);
        }
        $formData = $form->getData();
        $taskService->createTask($formData);
        return $this->redirectToRoute('app_task_view', ['id' => $task->getId()]);
    }


    #[Route('/task/edit/{id}', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request, TaskRepository $taskRepository, TaskService $taskService): Response
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $taskService->updateTask($task, $form->getData());
                // Redirect către pagina de listare sau altă pagină relevantă
                return $this->redirectToRoute('task_list');
            } catch (\Exception $e) {
                $this->addFlash('error', 'A apărut o eroare în timpul actualizării sarcinii. Vă rugăm să încercați din nou mai târziu.');
            }

            // Redirectează înapoi către pagina de editare pentru a afișa mesajul de eroare
            return $this->redirectToRoute('app_task_edit', ['id' => $id]);
        }

        return $this->render('task/update.html.twig', [
            'task_form' => $form->createView(),
        ]);
    }


    #[Route('/task/delete/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(int $id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }

        $entityManager->remove($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task deleted successfully'], Response::HTTP_OK);
    }
}
