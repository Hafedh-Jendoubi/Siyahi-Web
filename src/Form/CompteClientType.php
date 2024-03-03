<?php

namespace App\Form;


use App\Entity\CompteClient;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CompteClientType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $compteClient = new CompteClient();
        $builder
        ->add('service', ChoiceType::class, [
            'choices' => $this->getAvailableServices(),
            'choice_label' => 'name',
            'placeholder' => 'Choose a Service',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please choose a service.',
                ]),
            ],
        ])

            
            ->add('RIB', IntegerType::class, ['attr' => ['placeholder' => 'RIB'],
            'constraints' => [
                new Length(16)
            ]
        ])
        ->add('Created_at', DateType::class, [
            'data' => new \DateTime(),
            'years' => range(date("Y"), date("Y") + 10),
            'widget' => 'single_text',
        ])
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

    private function getAvailableServices(): array
    {
        $services = $this->entityManager->getRepository(Service::class)->findAll();
        $choices = [];

        foreach ($services as $service) {
            $choices[$service->getName()] = $service;
        }

        return $choices;
    }
}