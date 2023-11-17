<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gif $idGif = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $values = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdGif(): ?Gif
    {
        return $this->idGif;
    }

    public function setIdGif(?Gif $idGif): static
    {
        $this->idGif = $idGif;

        return $this;
    }

    public function getValues(): ?int
    {
        return $this->values;
    }

    public function setValues(int $values): static
    {
        $this->values = $values;

        return $this;
    }
}
