<?php

namespace App\Entity;

use App\Repository\ReponseCreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseCreditRepository::class)]
class ReponseCredit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $solde_a_payer = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debutPaiement = null;

    #[ORM\Column]
    private ?int $nbr_moisPaiement = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'reponseCredits')]
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
