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

  // -----------------------------
  // Preferences
  // -----------------------------
  #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
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

  public function __construct()
  {
    $this->profils = new ArrayCollection();
    $this->voitures = new ArrayCollection();
    $this->covoiturages = new ArrayCollection();
    $this->covoituragesPassager = new ArrayCollection();
    $this->avisRediges = new ArrayCollection();
    $this->avisRecus = new ArrayCollection();
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

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): static
  {
    $this->email = $email;

    return $this;
  }

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

  public function getRoles(): array
  {
    return $this->roles;
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

    return $this;
  }

  public function eraseCredentials(): void
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }
}
