<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Expression;



class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Object', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le champ Object ne peut pas être vide.']),
            ],
        ])
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
       /* ->add('status') // Ajoutez les contraintes nécessaires ici si besoin*/
        ->add('email', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le champ email ne peut pas être vide.']),
                new Email(['message' => 'L\'adresse email n\'est pas valide.']),
            ],
        ])
        //->add('User') // Si vous avez un champ User, ajoutez les contraintes nécessaires ici si besoin
    ;
}
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
   
}
