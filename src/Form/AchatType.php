<?php

namespace App\Form;

use App\Entity\Achat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Image',FileType::class, array('data_class' => null,'required' => false))
            ->add('Type', ChoiceType::class, [
                'choices'  => [
                    'Voiture' => 'Voiture',
                    'Appartement' => 'Appartement',
                    'Terrain' => 'Terrain',
                    // Ajoutez ici d'autres options si nécessaire
                ],
                'expanded' => true, // Afficher les boutons radio
            ])
            ->add('Description', TextareaType::class, [
                'attr' => ['rows' => 5], // spécifiez le nombre de lignes
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
