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

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Gif::class)]
    private Collection $gifs;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: Favorite::class, orphanRemoval: true)]
    private Collection $favorites;

    public function __construct()
    {
        $this->gifs = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Gif>
     */
    public function getGifs(): Collection
    {
        return $this->gifs;
    }

    public function addGif(Gif $gif): static
    {
        if (!$this->gifs->contains($gif)) {
            $this->gifs->add($gif);
            $gif->setAuthor($this);
        }

        return $this;
    }

    public function removeGif(Gif $gif): static
    {
        if ($this->gifs->removeElement($gif)) {
            // set the owning side to null (unless already changed)
            if ($gif->getAuthor() === $this) {
                $gif->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setIdUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getIdUser() === $this) {
                $favorite->setIdUser(null);
            }
        }

        return $this;
    }
}
