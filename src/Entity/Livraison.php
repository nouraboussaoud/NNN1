<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomC = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomC = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $TypePaiement = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Commande $IdCommande = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?User $IdClient = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?User $IdLivreur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->NomC;
    }

    public function setNomC(string $NomC): static
    {
        $this->NomC = $NomC;

        return $this;
    }

    public function getPrenomC(): ?string
    {
        return $this->prenomC;
    }

    public function setPrenomC(string $prenomC): static
    {
        $this->prenomC = $prenomC;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->TypePaiement;
    }

    public function setTypePaiement(string $TypePaiement): static
    {
        $this->TypePaiement = $TypePaiement;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->IdCommande;
    }

    public function setIdCommande(?Commande $IdCommande): static
    {
        $this->IdCommande = $IdCommande;

        return $this;
    }

    public function getIdClient(): ?User
    {
        return $this->IdClient;
    }

    public function setIdClient(?User $IdClient): static
    {
        $this->IdClient = $IdClient;

        return $this;
    }

    public function getIdLivreur(): ?User
    {
        return $this->IdLivreur;
    }

    public function setIdLivreur(?User $IdLivreur): static
    {
        $this->IdLivreur = $IdLivreur;

        return $this;
    }
}
