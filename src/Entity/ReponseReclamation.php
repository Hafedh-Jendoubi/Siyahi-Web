<?php

namespace App\Entity;

use App\Repository\ReponseReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[ORM\Entity(repositoryClass: ReponseReclamationRepository::class)]
class ReponseReclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'reponseReclamations')]
    private ?Reclamation $Reclamation = null;

    #[ORM\ManyToOne(inversedBy: 'reponseReclamations')]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 50)]
    private ?string $auteur = null;

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

    public function getReclamation(): ?Reclamation
    {
        return $this->Reclamation;
    }

    public function setReclamation(?Reclamation $Reclamation): static
    {
        $this->Reclamation = $Reclamation;

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
     /**
     * Get the string representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return sprintf(
                'ReponseReclamation {id: %s, Description: %s, Reclamation: %s, User: %s, DateCreation: %s, Auteur: %s}',
                $this->id,
                $this->Description,
                $this->Reclamation ? $this->Reclamation->getId() : 'null',
                $this->User ? $this->User->getId() : 'null',
                $this->dateCreation ? $this->dateCreation->format('Y-m-d') : 'null',
                $this->auteur
            );
        } catch (\Exception $e) {
            return 'Error in __toString method';
        }
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
    
}
