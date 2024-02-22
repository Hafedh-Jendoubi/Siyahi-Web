<?php

namespace App\Form;

use App\Entity\ReponseReclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;






class ReponseReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Description', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le champ Description ne peut pas être vide.']),
            ],
        ])
        ->add('dateCreation' ,DateType::class, [
            // ...
            'constraints' => [
                new LessThanOrEqual([
                    'value' => new \DateTime(),
                    'message' => 'La date de création ne peut pas être différent à aujourd\'hui.',
                ]),
            ],
        ])
        ->add('auteur', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le champ auteur ne peut pas être vide.']),
            ],
        ])
            ->add('Reclamation')
            /**->add('User', EntityType::class, [
                'choice_label' => 'username', // or any other property of User
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseReclamation::class,
        ]);
    }
}
