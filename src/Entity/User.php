<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message:"First Name is required.")]
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

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Achat::class)]
    private Collection $achats;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: CompteClient::class)]
    private Collection $compteClients;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\Column(length: 255)]
    private ?string $old_email = null;

    #[ORM\Column(length: 1)]
    private ?string $activity = null;

    public function __construct()
    {
        $this->reponseConges = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->reponseReclamations = new ArrayCollection();
        $this->credits = new ArrayCollection();
        $this->reponseCredits = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->achats = new ArrayCollection();
        $this->compteClients = new ArrayCollection();
        $this->services = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
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
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Achat>
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): static
    {
        if (!$this->achats->contains($achat)) {
            $this->achats->add($achat);
            $achat->setUser($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): static
    {
        if ($this->achats->removeElement($achat)) {
            // set the owning side to null (unless already changed)
            if ($achat->getUser() === $this) {
                $achat->setUser(null);
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getOldEmail(): ?string
    {
        return $this->old_email;
    }

    public function setOldEmail(string $old_email): static
    {
        $this->old_email = $old_email;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }
}
