<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  // -----------------------------
  // Champs
  // -----------------------------
  #[ORM\Column]
  private ?int $note = null;

  #[ORM\Column(length: 255)]
  private ?string $commentaire = null;

  #[ORM\Column(length: 50)]
  private ?string $statut = null;

  // Date auto-générée à la création de l’objet
  #[ORM\Column(type: Types::DATE_MUTABLE)]
  private ?\DateTimeInterface $date_avis = null;

  // -----------------------------
  // Relations
  // -----------------------------

  // Auteur de l'avis (obligatoire)
  #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'avisRediges')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $auteur = null;

  // Conducteur noté (obligatoire)
  #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'avisRecus')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $conducteur = null;

  public function __construct()
  {
    // date auto, non renseignée par user
    $this->date_avis = new \DateTimeImmutable();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNote(): ?int
  {
    return $this->note;
  }

  public function setNote(int $note): static
  {
    $this->note = $note;

    return $this;
  }

  public function getCommentaire(): ?string
  {
    return $this->commentaire;
  }

  public function setCommentaire(string $commentaire): static
  {
    $this->commentaire = $commentaire;

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

  public function getDateAvis(): ?\DateTime
  {
    return $this->date_avis;
  }

  public function setDateAvis(\DateTime $date_avis): static
  {
    $this->date_avis = $date_avis;

    return $this;
  }
}
