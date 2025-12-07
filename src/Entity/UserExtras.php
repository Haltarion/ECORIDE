<?php

namespace App\Entity;

use App\Repository\UserExtrasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserExtrasRepository::class)]
class UserExtras
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
  private ?string $credit = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 1, nullable: true)]
  private ?string $note = null;

  #[ORM\Column(length: 40, nullable: true)]
  private ?string $photo = null;

  // Dépendances vers d'autres entités

  // -----------------------------
  // Utilisateur
  // -----------------------------
  #[ORM\OneToOne(mappedBy: 'extras', targetEntity: User::class)]
  private ?User $user = null;

  // -----------------------------
  // Getters et Setters
  // -----------------------------
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getCredit(): ?string
  {
    return $this->credit;
  }

  public function setCredit(?string $credit): static
  {
    $this->credit = $credit;

    return $this;
  }

  public function getNote(): ?string
  {
    return $this->note;
  }

  public function setNote(?string $note): static
  {
    $this->note = $note;

    return $this;
  }

  public function getPhoto(): ?string
  {
    return $this->photo;
  }

  public function setPhoto(?string $photo): static
  {
    $this->photo = $photo;

    return $this;
  }
  // -----------------------------
  // Getters et Setters des autres entités
  // -----------------------------
  public function getUser(): ?User
  {
    return $this->user;
  }
  public function setUser(?User $user): static
  {
    $this->user = $user;
    return $this;
  }
}
