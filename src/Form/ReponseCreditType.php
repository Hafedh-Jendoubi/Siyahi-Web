<?php

namespace App\Form;

use App\Entity\ReponseCredit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseCreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('solde_a_payer')
            ->add('date_debutPaiement')
            ->add('nbr_moisPaiement')
            ->add('description')
            ->add('credit')
            ->add('submit',SubmitType::class,[
                'label'=>"Add Credit",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseCredit::class,
        ]);
    }
}
