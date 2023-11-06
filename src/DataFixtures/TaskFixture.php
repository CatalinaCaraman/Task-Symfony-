<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class TaskFixture extends AppFixtures
{
    public function load(ObjectManager $manager): void
    {
    $category = new Category();
    $category->setName("test_category");
    $task = new Task();
    $task->setTitle("test task");
    $task->setCategory($category);
    $task->setResult(true);
    $task->setDueDate(new \DateTime());
    $manager->flush();
    }
}
