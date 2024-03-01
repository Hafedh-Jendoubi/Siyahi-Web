<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional, so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('First_Name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'First Name cannot be blank.']),
                    new Length(['max' => 15, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Last_Name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Last Name cannot be blank.']),
                    new Length(['max' => 20, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('email', EmailType::class)
            ->add('Gender', ChoiceType::class, ['choices' => [
                'Male' => 'M',
                'Female' => 'F'
            ]])
            ->add('Address', TextType::class, [
                'constraints' => [
                    new Length(['max' => 50, 'maxMessage' => 'Address cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Phone_Number', NumberType::class, [
                'constraints' => [
                    new Length(8)
                ]
            ])
            ->add('CIN', NumberType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'CIN cannot be blank.']),
                    new Length(8)
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                    'Staff' => 'ROLE_STAFF',
                    'User' => 'ROLE_USER'
                ],
                'expanded' => true,
                'multiple' => true
            ])
            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
            ->add('Reset', ResetType::class, ['attr' => ['class' => 'btn btn-secondary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
