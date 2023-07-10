<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    
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
                'class' => User::class, // Update with the correct entity class (User)
                'label' => 'Members',
                'required' => false,
                'multiple' => true, // Allow selecting multiple members
                'attr' => [
                    'class' => 'form-control'
                ],
                // to update with fullname (in the user class) 
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}


