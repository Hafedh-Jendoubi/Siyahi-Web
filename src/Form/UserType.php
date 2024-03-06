<?php

namespace App\Form;

use App\Entity\User;
use http\Message;
use PHPUnit\Util\Type;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Image',

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
            ->add('FirstName', TextType::class, ['attr' => ['placeholder' => 'First Name*'],
                'constraints' => [
                    new NotBlank(['message' => 'First Name is required.']),
                    new Length(['max' => 15, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('LastName', TextType::class, ['attr' => ['placeholder' => 'Last Name*'],
                'constraints' => [
                    new NotBlank(['message' => 'Last Name is required.']),
                    new Length(['max' => 20, 'maxMessage' => 'First Name cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('Gender', ChoiceType::class, ['choices' => [
                'Male' => 'M',
                'Female' => 'F'
            ],
            ])
            ->add('oldemail', EmailType::class, ['attr' => ['label' => 'Email', 'placeholder' => 'Email*'],
                'constraints' => [
                    new NotBlank(['message' => 'Email is required.'])
                ]
            ])
            ->add('Address', TextType::class, ['attr' => ['placeholder' => 'Address'],
                'constraints' => [
                    new Length(['max' => 50, 'maxMessage' => 'Address cannot be longer than {{ limit }} characters.'])
                ]
            ])
            ->add('PhoneNumber', NumberType::class, ['attr' => ['placeholder' => 'Phone Number'],
                'constraints' => [
                    new Length(8)
                ]
            ])
            ->add('CIN', NumberType::class, ['attr' => ['placeholder' => 'CIN*'],
                'constraints' => [
                    new NotBlank(['message' => 'CIN is required.']),
                    new Length(8)
                ]
            ])
            ->add("Submit", SubmitType::class, ['attr'=> ['class' => 'btn btn-primary']])
            ->add("Reset", ResetType::class, ['attr'=> ['class' => 'btn btn-secondary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
