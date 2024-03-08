<?php

namespace App\Entity;

use App\Repository\CompteClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BigIntType;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\String_;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CompteClientRepository::class)]
#[UniqueEntity(fields: ['RIB'], message: 'This RIB is already in use.')]
class CompteClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: ' services de compte')]
    private ?Service $service = null;

    #[ORM\Column(type: "bigint", unique: true)]
    private ?int $RIB = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\EqualTo("today", message:"La date de début doit être ultérieure à aujourd'hui")]
    private ?\DateTimeInterface $Created_at = null;

    
    #[ORM\Column]
    private ?float $Solde = null;

    #[ORM\OneToMany(mappedBy: 'Compte_Client', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\ManyToOne(inversedBy: 'compteClients')]
    private ?User $User = null;



    

  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }


    public function getRIB(): ?int
    {
        return $this->RIB;
    }

    public function setRIB(int $RIB): static
    {
        $this->RIB = $RIB;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeInterface $Created_at): static
    {
        $this->Created_at = $Created_at;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->Solde;
    }

    public function setSolde(float $Solde): static
    {
        $this->Solde = $Solde;

        return $this;
    }

    public function addSolde(float $Solde):static{
        $this->Solde=$this->Solde+$Solde;
        return $this;
    }

   
    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCompteClient($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCompteClient() === $this) {
                $service->setCompteClient(null);
            }
        }

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

    public function __toString(): string
{
    $typeString = is_object($this->service) ? $this->service->getName() : (string) $this->service;

    return sprintf(
        'CompteClient [ID: %d, Type: %s, RIB: %d, Created_at: %s, Solde: %f]',
        $this->id,
        $typeString,
        $this->RIB,
        $this->Created_at ? $this->Created_at->format('Y-m-d H:i:s') : 'null',
        $this->Solde
    );
}

}