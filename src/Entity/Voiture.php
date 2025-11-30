<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(type: Types::DATE_MUTABLE)]
  private ?\DateTime $date_premiere_immatriculation = null;

  #[ORM\Column(type: 'string', length: 50)]
  private ?string $marque = null;

  #[ORM\Column(type: 'string', length: 50)]
  private ?string $modele = null;

  #[ORM\Column(type: 'string', length: 50)]
  private ?string $energie = null;

  #[ORM\Column(type: 'string', length: 50)]
  private ?string $couleur = null;

  #[ORM\Column(type: 'integer', options: ['min' => 1, 'max' => 6])]
  private ?int $nb_place_dispo = null;

  // immatriculation unique
  #[ORM\Column(type: 'string', length: 20, unique: true)]
  private ?string $immatriculation = null;

  // relation ManyToOne vers User
  #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'voitures')]
  #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
  private ?User $user = null;

  // relation OneToMany vers Covoiturages
  #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Covoiturage::class)]
  private Collection $covoiturages;

  public function __construct()
  {
    $this->covoiturages = new ArrayCollection();
  }

  // -----------------------------
  // Getters et Setters
  // -----------------------------
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getDatePremiereImmatriculation(): ?\DateTime
  {
    return $this->date_premiere_immatriculation;
  }

  public function setDatePremiereImmatriculation(\DateTime $date_premiere_immatriculation): static
  {
    $this->date_premiere_immatriculation = $date_premiere_immatriculation;

    return $this;
  }

  public function getMarque(): ?string
  {
    return $this->marque;
  }

  public function setMarque(string $marque): static
  {
    $this->marque = $marque;

    return $this;
  }

  public function getModele(): ?string
  {
    return $this->modele;
  }

  public function setModele(string $modele): static
  {
    $this->modele = $modele;

    return $this;
  }

  public function getEnergie(): ?string
  {
    return $this->energie;
  }

  public function setEnergie(string $energie): static
  {
    $this->energie = $energie;

    return $this;
  }

  public function getCouleur(): ?string
  {
    return $this->couleur;
  }

  public function setCouleur(string $couleur): static
  {
    $this->couleur = $couleur;

    return $this;
  }

  public function getNbPlaceDispo(): ?int
  {
    return $this->nb_place_dispo;
  }

  public function setNbPlaceDispo(int $nb_place_dispo): static
  {
    $this->nb_place_dispo = $nb_place_dispo;

    return $this;
  }
}
