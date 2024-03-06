<?php

namespace App\Entity;

use App\Repository\DemandeAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeAchatRepository::class)]
class DemandeAchat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir votre Nom ")]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir votre Prenom ")]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDemande = null;


    #[ORM\Column(length: 255)]
    #[Assert\Length(min:8)]
    #[Assert\Length(max:12)]
    #[Assert\NotBlank (message:"veuillez saisir votre numéro de télèphone ")]
    private ?string $numTel = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir le type de paiement ")]
    private ?string $TypePaiement = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"veuillez saisir votre CIN ")]
    #[Assert\Length(min:6)]
    #[Assert\Length(max:8)]
    private ?int $CIN = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir votre Adresse ")]
    private ?string $Adresse = null;

    #[ORM\ManyToOne(inversedBy: 'DemandeAchat')]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'DemandeAchat')]
    private ?Achat $Achat = null;

    #[ORM\Column(length: 255)]
    private ?string $etatdemande = null;


    public function __construct() {
        $this->DateDemande = new \dateTime('now');
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->DateDemande;
    }

    public function setDateDemande(\DateTimeInterface $DateDemande): static
    {
        $this->DateDemande = $DateDemande;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->TypePaiement;
    }

    public function setTypePaiement(string $TypePaiement): static
    {
        $this->TypePaiement = $TypePaiement;

        return $this;
    }

    public function getCIN(): ?int
    {
        return $this->CIN;
    }

    public function setCIN(int $CIN): static
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

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

    public function getAchat(): ?Achat
    {
        return $this->Achat;
    }

    public function setAchat(?Achat $Achat): static
    {
        $this->Achat = $Achat;

        return $this;
    }

    public function getEtatdemande(): ?string
    {
        return $this->etatdemande;
    }

    public function setEtatdemande(string $etatdemande): static
    {
        $this->etatdemande = $etatdemande;

        return $this;
    }
}
