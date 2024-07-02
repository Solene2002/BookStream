<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 150,
        minMessage: "Attention, votre titre doit contenir au moins {{ limit }} caractères",
        maxMessage: "Attention, votre titre ne doit pas contenir plus de {{limit}} caractères",
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Etat $etat = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Alike::class)]
    private Collection $alikes;

    #[ORM\Column(length: 255)]
    private ?string $audio = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modified_at = null;

    public function __construct()
    {
        $this->alikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Alike>
     */
    public function getAlikes(): Collection
    {
        return $this->alikes;
    }

    public function addAlike(Alike $alike): static
    {
        if (!$this->alikes->contains($alike)) {
            $this->alikes->add($alike);
            $alike->setLivre($this);
        }

        return $this;
    }

    public function removeAlike(Alike $alike): static
    {
        if ($this->alikes->removeElement($alike)) {
            // set the owning side to null (unless already changed)
            if ($alike->getLivre() === $this) {
                $alike->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * Fonction pour savoir si un livre est liké par un utilisateur 
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user){
        $likes=$this->getAlikes();
        foreach ($likes as $like) {
            if ($like->getUser()===$user){
                return true;
            }
        }
        return false;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(string $audio): static
    {
        $this->audio = $audio;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeImmutable $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    
}
