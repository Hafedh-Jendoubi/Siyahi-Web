<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
class Achat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir l'image de l'Achat ")]
    private $Image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir le type de l'Achat ")]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir la description de l'Achat ")]
    private ?string $Description = null;

    #[ORM\OneToMany(mappedBy: 'Achat', targetEntity: DemandeAchat::class)]
    private Collection $DemandeAchat;

    public function __construct()
    {
        $this->DemandeAchat = new ArrayCollection();
    }

    public function __ToString() {
        return $this->Type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage($Image)
    {
        $this->Image = $Image;

        return $this;
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
            $demandeAchat->setAchat($this);
        }

        return $this;
    }

    public function removeDemandeAchat(DemandeAchat $demandeAchat): static
    {
        if ($this->DemandeAchat->removeElement($demandeAchat)) {
            // set the owning side to null (unless already changed)
            if ($demandeAchat->getAchat() === $this) {
                $demandeAchat->setAchat(null);
            }
        }

        return $this;
    }
}
