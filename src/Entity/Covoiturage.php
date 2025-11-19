<?php

namespace App\Entity;

use App\Repository\CovoiturageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CovoiturageRepository::class)]
class Covoiturage
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  // -----------------------------
  // Champs du covoiturage
  // -----------------------------
  #[ORM\Column(type: Types::DATE_MUTABLE)]
  private ?\DateTime $date_depart = null;

  #[ORM\Column(type: Types::TIME_MUTABLE)]
  private ?\DateTime $heure_depart = null;

  #[ORM\Column(length: 50)]
  private ?string $adresse_depart = null;

  #[ORM\Column(type: Types::DATE_MUTABLE)]
  private ?\DateTime $date_arrivee = null;

  #[ORM\Column(length: 50)]
  private ?string $adresse_arrivee = null;

  #[ORM\Column(type: Types::TIME_MUTABLE)]
  private ?\DateTime $heure_arrivee = null;

  #[ORM\Column(length: 50)]
  private ?string $statut = null;

  #[ORM\Column]
  private ?int $nb_places = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
  private ?string $prix_par_personne = null;

  // -----------------------------
  // Relation obligatoire : voiture
  // -----------------------------
  #[ORM\ManyToOne(targetEntity: Voiture::class, inversedBy: 'covoiturages')]
  #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
  private ?Voiture $voiture = null;

  // -----------------------------
  // Relation obligatoire : conducteur
  // -----------------------------
  #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'covoiturages')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $conducteur = null;

  // -----------------------------
  // Relation ManyToMany : passagers
  // -----------------------------
  #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'covoituragesPassager')]
  #[ORM\JoinTable(name: "covoiturage_passagers")]
  private Collection $passagers;

  public function __construct()
  {
    $this->passagers = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getDateDepart(): ?\DateTime
  {
    return $this->date_depart;
  }

  public function setDateDepart(\DateTime $date_depart): static
  {
    $this->date_depart = $date_depart;

    return $this;
  }

  public function getHeureDepart(): ?\DateTime
  {
    return $this->heure_depart;
  }

  public function setHeureDepart(\DateTime $heure_depart): static
  {
    $this->heure_depart = $heure_depart;

    return $this;
  }

  public function getAdresseDepart(): ?string
  {
    return $this->adresse_depart;
  }

  public function setAdresseDepart(string $adresse_depart): static
  {
    $this->adresse_depart = $adresse_depart;

    return $this;
  }

  public function getDateArrivee(): ?\DateTime
  {
    return $this->date_arrivee;
  }

  public function setDateArrivee(\DateTime $date_arrivee): static
  {
    $this->date_arrivee = $date_arrivee;

    return $this;
  }

  public function getAdresseArrivee(): ?string
  {
    return $this->adresse_arrivee;
  }

  public function setAdresseArrivee(string $adresse_arrivee): static
  {
    $this->adresse_arrivee = $adresse_arrivee;

    return $this;
  }

  public function getHeureArrivee(): ?\DateTime
  {
    return $this->heure_arrivee;
  }

  public function setHeureArrivee(\DateTime $heure_arrivee): static
  {
    $this->heure_arrivee = $heure_arrivee;

    return $this;
  }

  public function getStatut(): ?string
  {
    return $this->statut;
  }

  public function setStatut(string $statut): static
  {
    $this->statut = $statut;

    return $this;
  }

  public function getNbPlaces(): ?int
  {
    return $this->nb_places;
  }

  public function setNbPlaces(int $nb_places): static
  {
    $this->nb_places = $nb_places;

    return $this;
  }

  public function getPrixParPersonne(): ?string
  {
    return $this->prix_par_personne;
  }

  public function setPrixParPersonne(string $prix_par_personne): static
  {
    $this->prix_par_personne = $prix_par_personne;

    return $this;
  }
}
