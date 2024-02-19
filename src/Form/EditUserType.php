<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                    'Staff' => 'ROLE_STAFF',
                    'User' => 'ROLE_USER'
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password', PasswordType::class, ['constraints' => [
                new NotBlank(['message' => 'Password cannot be blank.']),
                new Length(4)
            ]])
            ->add('First_Name', TextType::class, ['attr' => ['placeholder' => 'First Name*'],
                'constraints' => [
                    new NotBlank(['message' => 'First Name cannot be blank.']),
                    new Length(['max' => 15, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Last_Name', TextType::class, ['attr' => ['placeholder' => 'Last Name*'],
                'constraints' => [
                    new NotBlank(['message' => 'Last Name cannot be blank.']),
                    new Length(['max' => 20, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Gender', ChoiceType::class, ['choices' => [
                'Male' => 'M',
                'Female' => 'F'
            ]])
            ->add('Address', TextType::class, ['attr' => ['placeholder' => 'Address'],
                'constraints' => [
                    new Length(['max' => 50, 'maxMessage' => 'Address cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Phone_Number', NumberType::class, ['attr' => ['placeholder' => 'Phone Number'],
                'constraints' => [
                    new Length(8)
                ]
            ])
            ->add('CIN', NumberType::class, ['attr' => ['placeholder' => 'CIN*'],
                'constraints' => [
                    new NotBlank(['message' => 'cin cannot be blank.']),
                    new Length(8)
                ]
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
