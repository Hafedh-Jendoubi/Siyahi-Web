<?php

namespace App\Entity;

use App\Repository\CompteClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteClientRepository::class)]
class CompteClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column]
    private ?int $RIB = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $Created_at = null;

    #[ORM\Column]
    private ?float $Solde = null;

    #[ORM\OneToMany(mappedBy: 'Compte_Client', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\ManyToOne(inversedBy: 'compteClients')]
    private ?User $User = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $Created_at): static
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

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
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
    return sprintf(
        'CompteClient [ID: %d, Type: %s, RIB: %d, Created_at: %s, Solde: %f]',
        $this->id,
        $this->Type,
        $this->RIB,
        $this->Created_at ? $this->Created_at->format('Y-m-d H:i:s') : 'null',
        $this->Solde
    );
}

}