<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $First_Name = null;

    #[ORM\Column(length: 20)]
    private ?string $Last_Name = null;

    #[ORM\Column(length: 1)]
    private ?string $Gender = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Address = null;

    #[ORM\Column(nullable: true)]
    private ?int $Phone_Number = null;

    #[ORM\Column]
    private ?int $CIN = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $Created_At = null;

    #[ORM\Column(length: 15)]
    private ?string $Role = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: ReponseConge::class)]
    private Collection $reponseConges;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Reclamation::class)]
    private Collection $reclamations;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: ReponseReclamation::class)]
    private Collection $reponseReclamations;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Credit::class)]
    private Collection $credits;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: ReponseCredit::class)]
    private Collection $reponseCredits;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: CompteClient::class)]
    private Collection $compteClients;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: DemandeAchat::class)]
    private Collection $DemandeAchat;

    public function __toString()
    {
        return $this->Address;
    }
    public function __construct()
    {
        $this->reponseConges = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->reponseReclamations = new ArrayCollection();
        $this->credits = new ArrayCollection();
        $this->reponseCredits = new ArrayCollection();
        $this->compteClients = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->Commande = new ArrayCollection();
        $this->DemandeAchat = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->First_Name;
    }

    public function setFirstName(string $First_Name): static
    {
        $this->First_Name = $First_Name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->Last_Name;
    }

    public function setLastName(string $Last_Name): static
    {
        $this->Last_Name = $Last_Name;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->Phone_Number;
    }

    public function setPhoneNumber(?int $Phone_Number): static
    {
        $this->Phone_Number = $Phone_Number;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->Created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $Created_At): static
    {
        $this->Created_At = $Created_At;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    /**
     * @return Collection<int, ReponseConge>
     */
    public function getReponseConges(): Collection
    {
        return $this->reponseConges;
    }

    public function addReponseConge(ReponseConge $reponseConge): static
    {
        if (!$this->reponseConges->contains($reponseConge)) {
            $this->reponseConges->add($reponseConge);
            $reponseConge->setUser($this);
        }

        return $this;
    }

    public function removeReponseConge(ReponseConge $reponseConge): static
    {
        if ($this->reponseConges->removeElement($reponseConge)) {
            // set the owning side to null (unless already changed)
            if ($reponseConge->getUser() === $this) {
                $reponseConge->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseReclamation>
     */
    public function getReponseReclamations(): Collection
    {
        return $this->reponseReclamations;
    }

    public function addReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if (!$this->reponseReclamations->contains($reponseReclamation)) {
            $this->reponseReclamations->add($reponseReclamation);
            $reponseReclamation->setUser($this);
        }

        return $this;
    }

    public function removeReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if ($this->reponseReclamations->removeElement($reponseReclamation)) {
            // set the owning side to null (unless already changed)
            if ($reponseReclamation->getUser() === $this) {
                $reponseReclamation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): static
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setUser($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): static
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getUser() === $this) {
                $credit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseCredit>
     */
    public function getReponseCredits(): Collection
    {
        return $this->reponseCredits;
    }

    public function addReponseCredit(ReponseCredit $reponseCredit): static
    {
        if (!$this->reponseCredits->contains($reponseCredit)) {
            $this->reponseCredits->add($reponseCredit);
            $reponseCredit->setUser($this);
        }

        return $this;
    }

    public function removeReponseCredit(ReponseCredit $reponseCredit): static
    {
        if ($this->reponseCredits->removeElement($reponseCredit)) {
            // set the owning side to null (unless already changed)
            if ($reponseCredit->getUser() === $this) {
                $reponseCredit->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, CompteClient>
     */
    public function getCompteClients(): Collection
    {
        return $this->compteClients;
    }

    public function addCompteClient(CompteClient $compteClient): static
    {
        if (!$this->compteClients->contains($compteClient)) {
            $this->compteClients->add($compteClient);
            $compteClient->setUser($this);
        }

        return $this;
    }

    public function removeCompteClient(CompteClient $compteClient): static
    {
        if ($this->compteClients->removeElement($compteClient)) {
            // set the owning side to null (unless already changed)
            if ($compteClient->getUser() === $this) {
                $compteClient->setUser(null);
            }
        }

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
            $service->setUser($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getUser() === $this) {
                $service->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeAchat>
     */
    public function getDemandeAchat(): Collection
    {
        return $this->DemandeAchat;
    }

    public function addDemandeAchat(DemandeAchat $demandeAchat): static
    {
        if (!$this->DemandeAchat->contains($demandeAchat)) {
            $this->DemandeAchat->add($demandeAchat);
            $demandeAchat->setUser($this);
        }

        return $this;
    }

    public function removeDemandeAchat(DemandeAchat $demandeAchat): static
    {
        if ($this->DemandeAchat->removeElement($demandeAchat)) {
            // set the owning side to null (unless already changed)
            if ($demandeAchat->getUser() === $this) {
                $demandeAchat->setUser(null);
            }
        }

        return $this;
    }

}
