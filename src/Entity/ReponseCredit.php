<?php

namespace App\Entity;

use App\Repository\ReponseCreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReponseCreditRepository::class)]
class ReponseCredit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"C'est obligatoire de preciser un montant")]
    #[Assert\Length(min:"3", minMessage:"Le montant ne doit pas être inferieur à 100.")]
    private ?float $solde_a_payer = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message:"La date de début doit être superieur à aujourd'hui.")]
    private ?\DateTimeInterface $date_debutPaiement = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"C'est obligatoire de preciser le nombres de mois de paiement.")]
    private ?int $nbr_moisPaiement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"C'est obligatoire de préciser une raison.")]
    #[Assert\Length(min:"3", minMessage:"Cette valeur est trop courte. Elle doit comporter au moins 3 caractères.")]
    private ?string $description = null;
    

    #[ORM\ManyToOne(inversedBy: 'reponseCredits')]
    #[Assert\NotBlank(message:"C'est obligatoire de préciser à quel credit on va attribuer la reponse.")]
    private ?Credit $credit = null;

    #[ORM\ManyToOne(inversedBy: 'reponseCredits')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoldeAPayer(): ?float
    {
        return $this->solde_a_payer;
    }

    public function setSoldeAPayer(float $solde_a_payer): static
    {
        $this->solde_a_payer = $solde_a_payer;

        return $this;
    }

    public function getDateDebutPaiement(): ?\DateTimeInterface
    {
        return $this->date_debutPaiement;
    }

    public function setDateDebutPaiement(\DateTimeInterface $date_debutPaiement): static
    {
        $this->date_debutPaiement = $date_debutPaiement;

        return $this;
    }

    public function getNbrMoisPaiement(): ?int
    {
        return $this->nbr_moisPaiement;
    }

    public function setNbrMoisPaiement(int $nbr_moisPaiement): static
    {
        $this->nbr_moisPaiement = $nbr_moisPaiement;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCredit(): ?Credit
    {
        return $this->credit;
    }

    public function setCredit(?Credit $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
