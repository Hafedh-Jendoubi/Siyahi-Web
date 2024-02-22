<?php

namespace App\Form;

use App\Entity\Service;
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
class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['attr' => ['placeholder' => 'Name*'],
            'constraints' => [
                new NotBlank(['message' => 'Service Name cannot be blank.']),
                new Length(['max' => 15, 'maxMessage' => 'Service Name cannot be longer than {{ limit }} characters.'])
            ]
        ])
            ->add('Description', TextType::class, ['attr' => ['placeholder' => 'Description'],
            'constraints' => [
                new Length(['max' => 300, 'maxMessage' => 'Description cannot be longer than {{ limit }} characters.'])
            ]
        ])
            ->add('Compte_Client')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
