<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use DateTime;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;


class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class, ['label'=>'title', 'attr'=>['placeholder'=>'Type the title of your task', 'class'=>'Task',],
            'constraints' => [
                new Length(
                min: '2',
                max: '255',
                ),
                new NotNull(),
                
                new Regex(
                    pattern: '/^[A-Za-z0-9îăâțș ]+$/',
                    message: 'Titlul poate conține doar litere, cifre și spații.'
                )                

                ]
          ])
            ->add('description'
            , TextareaType::class, ['label'=>'description', 'attr'=>['placeholder'=>'Type the brief description of the task', 'class'=>'Task', 'rows' =>5, ],
            'constraints' => [
                new Length(
                min: '2',
                max: '255',
                ),
                new NotNull(),
                
                new Regex(
                    pattern: '/^[A-Za-z0-9îăâțș ]+$/',
                    message: 'Descrierea poate conține doar litere, cifre și spații.'
                )

                ]
          ])
          ->add('dueDate', DateType::class, [
            'widget' => 'single_text',
            
        ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
               
            ])
            ->add('category', EntityType::class, [ 
                'class' => Category::class, // Clasa entității specialitate 
                'choice_label' => 'name', 
                'label' => 'Category', 
                'placeholder' => 'Choose category', 
            ]) 
            ->add('submit', SubmitType::class, [ 
                'label' => 'Save', 
                'attr' => [ 
                    'class' => 'btn btn-primary', 
                ], 
        
            ]) 
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
