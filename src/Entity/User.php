<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  // -----------------------------
  // Champs obligatoires
  // -----------------------------
  #[ORM\Column(type: 'string', length: 50, unique: true)]
  private ?string $pseudo = null;

  #[ORM\Column(type: 'string', length: 50, unique: true)]
  private ?string $email = null;

  #[ORM\Column(length: 60)]
  private ?string $password = null;

  // -----------------------------
  // Rôles techniques Symfony
  // -----------------------------
  #[ORM\Column(type: 'json')]
  private array $roles = []; // ROLE_USER par défaut

  // Dépendances vers d'autres entités

  // -----------------------------
  // Preferences
  // -----------------------------
  #[ORM\OneToOne(inversedBy: 'user', targetEntity: Preferences::class, cascade: ['persist', 'remove'])]
  #[ORM\JoinColumn(nullable: true)]
  private ?Preferences $preferences = null;

  // -----------------------------
  // Profils métier (conducteur/passager)
  // -----------------------------
  #[ORM\ManyToMany(targetEntity: Profil::class, inversedBy: 'users')]
  #[ORM\JoinTable(name: "user_profils")]
  private Collection $profils;

  // -----------------------------
  // Voitures
  // -----------------------------
  #[ORM\OneToMany(mappedBy: 'user', targetEntity: Voiture::class, cascade: ['remove'])]
  private Collection $voitures;

  // -----------------------------
  // Covoiturages en tant que conducteur
  // -----------------------------
  #[ORM\OneToMany(mappedBy: 'conducteur', targetEntity: Covoiturage::class)]
  private Collection $covoiturages;

  // -----------------------------
  // Covoiturages en tant que passager
  // -----------------------------
  #[ORM\ManyToMany(targetEntity: Covoiturage::class, mappedBy: 'passagers')]
  private Collection $covoituragesPassager;

  // -----------------------------
  // Avis rédigés (auteur)
  // -----------------------------
  #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Avis::class)]
  private Collection $avisRediges;

  // -----------------------------
  // Avis reçus (conducteur noté)
  // -----------------------------
  #[ORM\OneToMany(mappedBy: 'conducteur', targetEntity: Avis::class)]
  private Collection $avisRecus;

  // -----------------------------
  // Extras utilisateur
  // -----------------------------
  #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
  #[ORM\JoinColumn(nullable: true)]
  private ?UserExtras $extras = null;

  public function __construct()
  {
    $this->profils = new ArrayCollection();
    $this->voitures = new ArrayCollection();
    $this->covoiturages = new ArrayCollection();
    $this->covoituragesPassager = new ArrayCollection();
    $this->avisRediges = new ArrayCollection();
    $this->avisRecus = new ArrayCollection();
  }

  // -----------------------------
  // Getters et Setters
  // -----------------------------

  public function getId(): ?int
  {
    return $this->id;
  }

  // Pseudo ----------------------
  public function getPseudo(): ?string
  {
    return $this->pseudo;
  }

  public function setPseudo(string $pseudo): static
  {
    $this->pseudo = $pseudo;

    return $this;
  }

  // Email ----------------------
  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): static
  {
    $this->email = $email;

    return $this;
  }

  // UserInterface methods ----------------------
  public function getUserIdentifier(): string
  {
    return $this->email;
  }


  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): static
  {
    $this->password = $password;

    return $this;
  }

  // -----------------------------
  // Getters et Setters des autres entités
  // -----------------------------

  // Extras utilisateur
  public function getExtras(): ?UserExtras
  {
    return $this->extras;
  }
  public function setExtras(?UserExtras $extras): self
  {
    $this->extras = $extras;
    return $this;
  }

  // Rôles techniques Symfony
  public function getRoles(): array
  {
    $roles = $this->roles;
    $roles[] = 'ROLE_USER';
    return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

    return $this;
  }

  // Profils métier
  public function getProfils(): Collection
  {
    return $this->profils;
  }

  public function addProfil(?Profil $profil): static
  {
    if (!$this->profils->contains($profil)) {
      $this->profils->add($profil);
    }
    return $this;
  }

  public function removeProfil(Profil $profil): static
  {
    $this->profils->removeElement($profil);

    return $this;
  }

  public function hasProfil(Profil $profil): bool
  {
    return $this->profils->contains($profil);
  }

  // Preferences
  public function getPreferences(): ?Preferences
  {
      return $this->preferences;
  }

  public function setPreferences(?Preferences $preferences): static
  {
      $this->preferences = $preferences;
      return $this;
  }

  // Vehivules
  public function getVoitures(): Collection
  {
    return $this->voitures;
  }

  public function addVoiture(?Voiture $voiture): static
  {
    if (!$this->voitures->contains($voiture)) {
      $this->voitures->add($voiture);
    }
    return $this;
  }

  public function removeVoiture(Voiture $voiture): static
  {
    $this->voitures->removeElement($voiture);

    return $this;
  }

  public function hasVoiture(Voiture $voiture): bool
  {
    return $this->voitures->contains($voiture);
  }

  public function eraseCredentials(): void
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }
}
