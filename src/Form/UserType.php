<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextTypeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Config\Twig\NumberFormatConfig;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('First_Name', TextType::class, ['attr' => ['placeholder' => 'First Name']])
            ->add('Last_Name', TextType::class, ['attr' => ['placeholder' => 'Last Name']])
            ->add('Gender', ChoiceType::class, ['choices' => [
                'Male' => 'M',
                'Female' => 'F'
            ],
            ])
            ->add('Address', TextType::class, ['attr' => ['placeholder' => 'Address']])
            ->add('Phone_Number', NumberType::class, ['attr' => ['placeholder' => 'Phone Number']])
            ->add('CIN', NumberType::class, ['attr' => ['placeholder' => 'CIN']])
            ->add("Submit", SubmitType::class)
            ->add("Reset", ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
