<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date_creation;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_modification;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $content;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $header;

    #[ORM\Column(type: 'text', nullable: true)]
    private $script;

    #[ORM\Column(type: 'json')]
    private $tags = [];

    #[ORM\Column(type: 'json')]
    private $categories = [];

    #[ORM\Column(type: 'text', nullable: true)]
    private $featuredMedia;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $auteur;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private $visibility;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->date_modification;
    }

    public function setDateModification(?\DateTimeInterface $date_modification): self
    {
        $this->date_modification = $date_modification;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getScript(): ?string
    {
        return $this->script;
    }

    public function setScript(?string $script): self
    {
        $this->script = $script;

        return $this;
    }

    public function getTags(): array
    {
        $tags = $this->tags;

        return array_unique($tags);
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getCategories(): array
    {
        $categories = $this->categories;

        return array_unique($categories);
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getFeaturedMedia(): ?string
    {
        return $this->featuredMedia;
    }

    public function setFeaturedMedia(?string $featuredMedia): self
    {
        $this->featuredMedia = $featuredMedia;

        return $this;
    }

    public function getAuteur(): ?int
    {
        return $this->auteur;
    }

    public function setAuteur(?int $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(?bool $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }


    
}
