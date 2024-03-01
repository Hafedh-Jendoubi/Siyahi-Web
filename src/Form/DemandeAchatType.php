<?php

namespace App\Form;

use App\Entity\DemandeAchat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Achat;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DemandeAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('DateDemande')
            ->add('numTel')
            ->add('TypePaiement', ChoiceType::class, [
                'choices'  => [
                    'Virement Bancaire ' => 'Virement Bancaire',
                    'Cheque' => 'Cheque',
                    'Espèce' => 'Espèce',
                    // Ajoutez ici d'autres options si nécessaire
                ],
                'expanded' => true, // Afficher les boutons radio
            ])
            ->add('CIN')
            ->add('Adresse')
            ->add('User',EntityType::class,['class'=> User::class,
            'choice_label'=>'Address',
            'label'=>'Email User'])
            ->add('Achat',EntityType::class,['class'=> Achat::class,
            'choice_label'=>'Type',
            'label'=>'Achat'])
            ->add('etatdemande', HiddenType::class, [
                'data' => 'en cours de traitement',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeAchat::class,
        ]);
    }
}
