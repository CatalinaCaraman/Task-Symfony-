<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function createTask(array $formData)
    {
        // Creăm o nouă sarcină pe baza datelor din formular
        $task = new Task();
        $task->setTitle($formData['name']);
        $task->setDescription($formData['description']);
        // Salvăm sarcina în baza de date
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        return $task;
    }
    public function updateTask(Task $task, array $formData)
    {
        // Actualizăm datele sarcinii pe baza datelor din formular
        $task->setTitle($formData['name']);
        $task->setDescription($formData['description']);
        // Salvăm sarcina actualizată în baza de date
        $this->entityManager->flush();
        return $task;
    }
    //stergem sarcina
    public function deleteTask(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    public function getAllTasks(): array
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }
}
