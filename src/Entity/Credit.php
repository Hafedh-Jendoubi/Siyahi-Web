<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $solde_demande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut_paiement = null;

    #[ORM\Column]
    private ?int $nbr_mois_paiement = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'credit', targetEntity: ReponseCredit::class)]
    private Collection $reponseCredits;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    private ?User $User = null;

    public function __construct()
    {
        $this->reponseCredits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoldeDemande(): ?float
    {
        return $this->solde_demande;
    }

    public function setSoldeDemande(float $solde_demande): static
    {
        $this->solde_demande = $solde_demande;

        return $this;
    }

    public function getDateDebutPaiement(): ?\DateTimeInterface
    {
        return $this->date_debut_paiement;
    }

    public function setDateDebutPaiement(\DateTimeInterface $date_debut_paiement): static
    {
        $this->date_debut_paiement = $date_debut_paiement;

        return $this;
    }

    public function getNbrMoisPaiement(): ?int
    {
        return $this->nbr_mois_paiement;
    }

    public function setNbrMoisPaiement(int $nbr_mois_paiement): static
    {
        $this->nbr_mois_paiement = $nbr_mois_paiement;

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
            $reponseCredit->setCredit($this);
        }

        return $this;
    }

    public function removeReponseCredit(ReponseCredit $reponseCredit): static
    {
        if ($this->reponseCredits->removeElement($reponseCredit)) {
            // set the owning side to null (unless already changed)
            if ($reponseCredit->getCredit() === $this) {
                $reponseCredit->setCredit(null);
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
}
