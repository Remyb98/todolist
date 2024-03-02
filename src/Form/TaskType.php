<?php

namespace App\Form;

use App\Data\TaskState;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('state', EnumType::class, [
                'class' => TaskState::class
            ])
            ->add('assignee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('dueDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
