<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "utilisateurs")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 45)]
  private ?string $pseudo = null;

  #[ORM\Column(length: 45)]
  private ?string $email = null;

  #[ORM\Column(length: 60)]
  private ?string $password = null;

  #[ORM\Column(type: Types::BLOB, nullable: true)]
  private $photo = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
  private ?string $credit = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 1, scale: 1, nullable: true)]
  private ?string $note = null;

  #[ORM\Column(nullable: false)]
  private ?int $role_of = 1;

  #[ORM\Column(nullable: true)]
  private ?int $user_preferences = null;

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

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): static
  {
    $this->password = $password;

    return $this;
  }

  public function getPhoto()
  {
    return $this->photo;
  }

  public function setPhoto($photo): static
  {
    $this->photo = $photo;

    return $this;
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

  public function getRoleOf(): ?int
  {
    return $this->role_of;
  }

  public function setRoleOf(?int $role_of): static
  {
    $this->role_of = $role_of;

    return $this;
  }

  public function getUserPreferences(): ?int
  {
    return $this->user_preferences;
  }

  public function setUserPreferences(?int $user_preferences): static
  {
    $this->user_preferences = $user_preferences;

    return $this;
  }

  // Méthodes requises par UserInterface
  public function getRoles(): array
  {
    return ['ROLE_USER'];
  }

  public function eraseCredentials(): void
  {
    // Effacer les données sensibles temporaires si nécessaire
  }

  public function getUserIdentifier(): string
  {
    return (string) $this->email;
  }
}
