<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 50, unique: true)]
  private ?string $libelle = null;

  // -----------------------------
  // Getters et Setters
  // -----------------------------
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getLibelle(): ?string
  {
    return $this->libelle;
  }

  public function setLibelle(string $libelle): static
  {
    $this->libelle = $libelle;

    return $this;
  }

  // -----------------------------
  // Users associés à ce profil
  // -----------------------------
  #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'profils')]
  private Collection $users;

  public function __construct()
  {
    $this->users = new ArrayCollection();
  }
}
