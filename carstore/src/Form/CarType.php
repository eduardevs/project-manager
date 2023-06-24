<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Model\'s name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('cost', NumberType::class, [
                'label' => 'Price',
                'required'=> true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('nbSeats', NumberType::class, [
                'label' => 'How many seats ?',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Max seats up to 8',
                    'class' => 'form-control',
                    'pattern' => '^[1-8]{1,8}$', 
                ],  
            ])
            ->add('nbDoors', ChoiceType::class, [
                'label' => 'How many doors ?',
                'required' => true,
                'choices' => [
                    '2' => 2,
                    '4' => 4,
                    '6' => 6,
                    '8' => 8
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => CarCategory::class,
                'label' => 'Categories',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
