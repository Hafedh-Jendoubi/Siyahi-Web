<?php

namespace App\Form;

use App\Entity\CompteClient;
use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\Util\Type;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;

class CompteClientType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $compteClient = new CompteClient();
        $builder
            ->add('Type')

            
            ->add('RIB', IntegerType::class, ['attr' => ['placeholder' => 'RIB'],
            'constraints' => [
                new Length(16)
            ]
        ])
            ->add('Created_at')
            ->add('Solde' , NumberType::class, ['attr' => ['placeholder' => 'Solde'],
            'constraints' => [
                new Regex([
                    'pattern' => '/^\d+(\.\d{1,3})?$/',
                    'message' => 'The value should have up to 3 decimal places.'])
            ]]) // Champ Solde désactivé
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompteClient::class,
        ]);
    }
}
