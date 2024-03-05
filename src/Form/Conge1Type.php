<?php

namespace App\Form;

use App\Entity\Conge;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Conge1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Description')
            ->add('Date_Debut', DateType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            ->add('Date_Fin', DateType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            ->add('Justification', FileType::class, [
                'label' => 'Justification',
                'mapped' => false, // Indique que ce champ n'est pas lié à une propriété de l'entité
                'required' => false, // Rend le champ facultatif pour les éditions
            ])
            
            
            ->add('submit',SubmitType::class,[
                'label'=>"confirmé ",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
