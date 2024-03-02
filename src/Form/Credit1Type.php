<?php

namespace App\Form;

use App\Entity\Credit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Credit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('solde_demande')
            ->add('date_debut_paiement', DateType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            
            ->add('nbr_mois_paiement')
            ->add('description',TextType::class,[
                'attr'=>[ 
                    'class'=>'border mt-2 mx-2',
                    'autofocus'=>'true',
                    'minlength'=>2,
                    'maxlength'=>50,
                    'placeholder'=>'WHY...',
                    'required'=>'true'
                ]
            ])
          

            ->add('Contrat', FileType::class, [
                'label' => 'Contrat ',
                'mapped' => false,
                'required' => false,
                // Ajoutez d'autres options selon vos besoins
            ])
        
           /* ->add('User', EntityType::class, [
                'class' => 'App\Entity\User', // Replace with the actual namespace of your Author entity
                'choice_label' => 'First_Name', // Assuming Author entity has a method getFullName() that returns the author's full name
                'placeholder' => 'Select an User', // Optional, adds an empty option at the top
                'required' => true,]) // Set to true if the author selection is mandatory
           */
                ->add('submit',SubmitType::class,[
                    'label'=>"confirmer",
                ])  
            ;
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
