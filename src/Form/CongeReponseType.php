<?php

namespace App\Form;

use App\Entity\Conge;
use App\Entity\ReponseConge;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('DateDebut', DateType::class, [
            'data' => new \DateTime(),
            'years' => range(date("Y"), date("Y") + 10),
            'widget' => 'single_text',
        ])
        ->add('DateFin', DateType::class, [
            'data' => new \DateTime(),
            'years' => range(date("Y"), date("Y") + 10),
            'widget' => 'single_text',
        ])
            ->add('description')
            ->add('Conge', EntityType::class, [
                'class' => Conge::class,
                'choice_label' => 'id', // ou tout autre champ que vous souhaitez afficher
            ])
            ->add('submit',SubmitType::class,[
                'label'=>" confirmé",
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseConge::class,
        ]);
    }
}
