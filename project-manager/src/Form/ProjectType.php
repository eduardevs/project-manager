<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('startDate', DateType::class, [
                'required' => false
            ])
            ->add('endDate')
            ->add('status')
            ->add('members', EntityType::class, [
                'class' => User::class,
                'label' => 'Members',
                'required' => false,
                'multiple' => true,
                'expanded' => true, // Use checkboxes for individual choices
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_label' => function (User $user) {
                    return $user->getFirstName();
                }
            ])
            ->add('save', SubmitType::class, [ // Change button label to 'save'
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
    }

    private function getUserChoices(): array
    {
        // Retrieve the list of available users from the database or any other source
        // You can customize this method based on your logic to get the list of users.

        // Here's an example assuming you have a User repository
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $choices = [];
        foreach ($users as $user) {
            // Assuming your User entity has a "getFullName()" method
            $choices[$user->getFirstName()] = $user->getId();
        }
        

        return $choices;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}

