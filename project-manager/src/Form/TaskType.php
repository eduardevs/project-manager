<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('dueDate')
            ->add('priority')
            ->add('status')
            ->add('assignedTo', EntityType::class, [
                'class' => User::class,
                // 'choice_label' => '',
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [ // Change button label to 'save'
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
            // ->add('project')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
