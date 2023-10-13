# Task-Symfony-
It's an app to manage tasks
Introduction: So in this project i made a small app to help manage tasks using symfony framework. In here we have some pages like (create, list, task) and some functionalities we can do like (update or delete). 
Each task has the create form(title, description, due date,created at and category), category was added directlly in the data base (sqlite in my case).
In the data base I created the structure of the task and category step by step. Fields title and description has constrains like length and regex(we can write down just small or big letters, or numbers)
(I am not a big fan of talkie-talkie)
We can emphasize the TaskController and taskType, I think they are really cool. 
TaskController handles the incoming HTTP request, processes it, and returns an HTTP response. In controller we have some routes like (list, view{}, task, task/create, task/update).
TaskType refers to a form type it extends AbstractType. 
Form types are a way of defining and handling forms in Symfony applications. Symfony provides a powerful and flexible system for building forms, and form types are a key part of this system.
In TaskType I defined my form with constrains and the button submit.
Also I have used .twig files that are templates that use the Twig templating engine to generate dynamic HTML, XML, or any other markup formats. 
Twig is a powerful, and developer-friendly templating engine that allows you to write concise and readable templates for your Symfony applications.
In list.html.twig I created two buttons one for updating the task and one for deleting the task, so when a task is created we get send to list/task where we can visualize each task(title) and update or delete them.
It was possible to achive by using link to route task/delete and task/update.
I dind't really use some sources for this project, but the presentasion of my teacher. (so can't link anything)
Some QandA
What are the advantages of using the Symfony framework?
I think it's easier to deal with than trying e.g to make an small app in php only. It's really flexible provides flexibility in choosing components and libraries, 
enabling developers to tailor the framework according to their project requirements. It has a great scalability, that offers the possibility to scale programs, making them suitable for both small and large-scale projects.
What are the methods for defining routes in Symfony?
Routes in Symfony can be defined using YAML, XML, PHP annotations, or PHP code. PHP annotations are a popular choice due to their simplicity and readability.
In my project is defined routes.yaml
What relationship between database tables did you use, and how did you implement it?
I used ManyToOne relationship between Task and Category. The reasoning behind this is that many tasks can have same category like "doing" or "done".
What are database migrations, and how are they used in Symfony?
Database migrations in Symfony are version control for database schema. They allow us to update database schema over time while preserving existing data. 
Symfony uses Doctrine Migrations bundle, which provides a set of convenient tools for working with database migrations.
I remember we used php bin/console make:migration, so a database migration is a change to the database structure, such as adding or changing tables, columns, or foreign keys.
