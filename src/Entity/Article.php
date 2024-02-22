<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir l'image de l'article ")]
    private $Image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir le type de l'article ")]
    private ?string $Type = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"veuillez saisir le nombre d'article ")]
    private ?int $NbArticle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"veuillez saisir la description de l'article ")]
    private ?string $Description = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"veuillez saisir le prix de l'article ")]
    private ?float $Prix = null;

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

    public function getNbArticle(): ?int
    {
        return $this->NbArticle;
    }

    public function setNbArticle(int $NbArticle): static
    {
        $this->NbArticle = $NbArticle;

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

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }
}
