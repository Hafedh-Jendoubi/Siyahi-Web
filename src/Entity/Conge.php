<?php

namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongeRepository::class)]
class Conge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   
     #[ORM\Column(length: 255)]
     #[Assert\NotBlank(message:"La description est obligatoire")]
     #[Assert\Length(max:"255", maxMessage:"La description ne doit pas dépasser {{ limit }} caractères")]
     
    private ?string $Description = null;

    

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message:"La date de début doit être ultérieure à aujourd'hui")]
    private ?\DateTimeInterface $Date_Debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Expression(
           "this.getDateFin() >= this.getDateDebut()",
            message:"La date de fin doit être postérieure ou égale à la date de début"
         )]
    private ?\DateTimeInterface $Date_Fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    private ?string $Justification = null;

    #[ORM\OneToMany(mappedBy: 'Conge', targetEntity: ReponseConge::class)]
    private Collection $reponseConges;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_demande = null;

    #[ORM\Column(length: 255)]
    private ?string $Type_conge = null;

    #[ORM\Column( nullable: true)]
    private ?bool $status = null;

    public function __construct()
    {
        $this->reponseConges = new ArrayCollection();
        $this->status = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_Debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_Debut): static
    {
        $this->Date_Debut = $Date_Debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_Fin;
    }

    public function setDateFin(\DateTimeInterface $Date_Fin): static
    {
        $this->Date_Fin = $Date_Fin;

        return $this;
    }

    public function getJustification(): ?string
    {
        return $this->Justification;
    }

    public function setJustification(?string $Justification): static
    {
        $this->Justification = $Justification;

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
            $reponseConge->setConge($this);
        }

        return $this;
    }

    public function removeReponseConge(ReponseConge $reponseConge): static
    {
        if ($this->reponseConges->removeElement($reponseConge)) {
            // set the owning side to null (unless already changed)
            if ($reponseConge->getConge() === $this) {
                $reponseConge->setConge(null);
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

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->Date_demande;
    }

    public function setDateDemande(\DateTimeInterface $Date_demande): static
    {
        $this->Date_demande = $Date_demande;

        return $this;
    }

    public function getTypeConge(): ?string
    {
        return $this->Type_conge;
    }

    public function setTypeConge(string $Type_conge): static
    {
        $this->Type_conge = $Type_conge;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}