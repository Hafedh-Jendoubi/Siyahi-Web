<?php

namespace App\Entity;

use App\Repository\ReponseCongeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReponseCongeRepository::class)]
class ReponseConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message:"La date de début doit être ultérieure à aujourd'hui")]
    private ?\DateTimeInterface $DateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Expression(
        "this.getDateFin() >= this.getDateDebut()",
         message:"La date de fin doit être postérieure ou égale à la date de début"
      )]
    private ?\DateTimeInterface $DateFin = null;

    #[ORM\ManyToOne(inversedBy: 'reponseConges')]
    private ?Conge $Conge = null;

    #[ORM\ManyToOne(inversedBy: 'reponseConges')]
    private ?User $User = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"La description est obligatoire")]
     #[Assert\Length(max:"255", maxMessage:"La description ne doit pas dépasser {{ limit }} caractères")]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getConge(): ?Conge
    {
        return $this->Conge;
    }

    public function setConge(?Conge $Conge): static
    {
        $this->Conge = $Conge;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
