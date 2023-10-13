<?php 
 
namespace App\Controller; 
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 
use App\Repository\TaskRepository; 
use App\Entity\Task; 
use App\Entity\Category; 
use App\Form\TaskType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request; 
use Doctrine\ORM\EntityManagerInterface; 
 
 
class TaskController extends AbstractController 
{ 
    #[Route('/list', name: 'list', methods:["GET"])]
    public function list(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();

        return $this->render('to_do/list.html.twig', [
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

        return $this->render('to_do/view.html.twig', [
            'task' => $task,
        ]);
    }
    #[Route('/task', name: 'app_student')] 
    public function index(): Response 
    { 
        return $this->render('to_do/index.html.twig', [ 
            'controller_name' => 'TaskController', 
        ]); 
    } 
 
    #[Route('/task/create', name: 'taskcreate')] 
    public function create(EntityManagerInterface $entityManager, Request $request): Response 
    { 
        $task = new Task(); 
        $form = $this->createForm(TaskType::class, $task); 
        $form->handleRequest($request); 
     
        if (!($form->isSubmitted() && $form->isValid())) { 
            return $this->render('to_do/create.html.twig', [ 
                'task_form' => $form, 
            ]); 
        } 
     
        $entityManager->persist($task); 
        $entityManager->flush(); 
     
        return $this->redirectToRoute('list'); // Redirecționați corect la ruta 'taskupdate' 
    } 

    #[Route('/task/update/{id}', name: 'taskupdate')]
public function update(int $id, Request $request, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
{
    $task = $taskRepository->find($id);

    if (!$task) {
        throw $this->createNotFoundException('Task not found');
    }

    $form = $this->createForm(TaskType::class, $task);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        try {
            $entityManager->flush();

            // Redirect către pagina de listare sau altă pagină relevantă
            return $this->redirectToRoute('task_list');
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash('error', 'Aceasta este o eroare unică în baza de date.');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('error', 'Aceasta este o eroare de cheie străină în baza de date.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'A apărut o eroare în timpul actualizării sarcinii. Vă rugăm să încercați din nou mai târziu.');
        }

        // Redirectează înapoi către pagina de editare pentru a afișa mesajul de eroare
        return $this->redirectToRoute('taskupdate', ['id' => $id]);
    
    
    }

    return $this->render('to_do/update.html.twig', [
        'task_form' => $form->createView(),
    ]);
}

    #[Route('/task/delete/{id}', name: 'taskdelete')] 
    public function delete(int $id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response 
    { 
        $task = $taskRepository->find($id); 
     
        if (!$task) { 
            throw $this->createNotFoundException('Task not found'); 
        } 
     
        $entityManager->remove($task); 
        $entityManager->flush(); 
     
        return $this->redirectToRoute('taskcreate'); // Redirecționați corect la ruta 'taskcreate' 
    } 
    
    
}
