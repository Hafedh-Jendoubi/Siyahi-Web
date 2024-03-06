<?php

namespace App\Form;

use App\Entity\ReponseCredit;
use App\Entity\Credit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseCredit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('solde_a_payer')
            ->add('date_debutPaiement', DateType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            ->add('nbr_moisPaiement')
            ->add('description')
            ->add('credit', EntityType::class, [
                'class' => Credit::class,
                'choice_label' => 'id',
                'placeholder' => 'Select a credit',
                'required' => true,
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->leftJoin('c.reponseCredits', 'r')
                        ->where('r.id IS NULL');
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Confirmer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseCredit::class,
        ]);
    }
}
