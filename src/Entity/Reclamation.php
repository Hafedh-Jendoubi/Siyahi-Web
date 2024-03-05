<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Object = null;
    #[Assert\NotBlank(message:"Le champ Object ne peut pas être vide.")]

    

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\OneToMany(mappedBy: 'Reclamation', targetEntity: ReponseReclamation::class,cascade: ['remove'])]
    public Collection $reponseReclamations;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    public ?User $User = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
   /* #[Assert\GreaterThan("today", message:"La date de création ne peut pas être postérieure à aujourd\'hui.")]*/
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column(length: 15)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function __construct()
    {
        $this->reponseReclamations = new ArrayCollection();
        $this->status = 'Non traitée'; // Valeur par défaut
        $this->dateCreation = new \DateTime(); // Date de création automatique
    }
    public function updateStatus(): void
    {
        if (!$this->reponseReclamations->isEmpty()) {
            $this->status = 'Répondue';
        } else {
            $this->status = 'Non traitée';
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->Object;
    }

    public function setObject(string $Object): static
    {
        $this->Object = $Object;

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

    /**
     * @return Collection<int, ReponseReclamation>
     */
    public function getReponseReclamations(): Collection
    {
        return $this->reponseReclamations;
    }
    /*////teeeeeeeeeeeeeeeeeeeeeeeeeest/*///
    /**
 * @return ReponseReclamation|null
 */
public function getFirstReponse(): ?ReponseReclamation
{
    return $this->reponseReclamations->first();
}
/************ */

    public function addReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if (!$this->reponseReclamations->contains($reponseReclamation)) {
            $this->reponseReclamations->add($reponseReclamation);
            $reponseReclamation->setReclamation($this);
        }

        return $this;
    }

    public function removeReponseReclamation(ReponseReclamation $reponseReclamation): static
    {
        if ($this->reponseReclamations->removeElement($reponseReclamation)) {
            // set the owning side to null (unless already changed)
            if ($reponseReclamation->getReclamation() === $this) {
                $reponseReclamation->setReclamation(null);
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
    public function __toString()
    {
        return sprintf(
            'Reclamation {id: %s, Object: %s, Description: %s, User: %s, DateCreation: %s, Auteur: %s}',
            $this->getId() !== null ? $this->getId() : 'null',
            $this->getObject() !== null ? $this->getObject() : 'null',
            $this->getDescription() !== null ? $this->getDescription() : 'null',
            $this->getUser() !== null ? $this->getUser()->getId() : 'null',
            $this->getDateCreation() !== null ? $this->getDateCreation()->format('Y-m-d') : 'null',
            $this->getAuteur() !== null ? $this->getAuteur() : 'null'
        );
    }

    
}
