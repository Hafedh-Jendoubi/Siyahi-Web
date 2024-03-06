<?php

namespace App\Form;

use App\Entity\Credit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('solde_demande')
            ->add('date_debut_paiement')
            ->add('nbr_mois_paiement')
            ->add('description')
            ->add('submit',SubmitType::class,[
                'label'=>"Add Credit",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
