<?php

namespace App\Form;

use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class TransferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('RIB', IntegerType::class, [
                'attr' => ['placeholder' => 'RIB'],
                'constraints' => [
                    new Length(16),
                ],
            ])
            ->add('amount' , NumberType::class, ['attr' => ['placeholder' => 'Solde'],
            'constraints' => [
                new Regex([
                    'pattern' => '/^\d+(\.\d{1,3})?$/',
                    'message' => 'The value should have up to 3 decimal places.'])
            ]]);
    }

    public function validateAmount($value, ExecutionContextInterface $context,UserRepository $repository, ManagerRegistry $managerRegistry)
    {
        // Get the current user
        $currentUser = $this->getUser();
        $user = $repository->findOneByEmail($currentUser->getUserIdentifier());

        // Find the current user's CompteClient objects
        $compteClients = $user->getCompteClients();

        // Check if the amount is valid based on the current user's CompteClient balances
        $valid = false;
        foreach ($compteClients as $compteClient) {
            $balance = $compteClient->getSolde();

            if ($value > 0 && $value <= $balance) {
                $valid = true;
                break;
            }
        }

        // Add a validation error if the amount is not valid
        if (!$valid) {
            $context->buildViolation('Le montant spécifié n\'est pas valide.')
                ->atPath('amount')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
