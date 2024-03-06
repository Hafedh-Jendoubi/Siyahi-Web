<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    /*#[ORM\ManyToOne(inversedBy: 'services')]
    private ?CompteClient $Compte_Client = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?User $User = null;*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName(); // Assuming Service entity has a getName method
    }
/*public function getCompteClient(): ?CompteClient
    {
        return $this->Compte_Client;
    }

    public function setCompteClient(?CompteClient $Compte_Client): static
    {
        $this->Compte_Client = $Compte_Client;

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
    }*/
}
