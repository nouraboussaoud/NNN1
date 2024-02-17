<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Livraison $IdLiv = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $IdUs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdLiv(): ?Livraison
    {
        return $this->IdLiv;
    }

    public function setIdLiv(?Livraison $IdLiv): static
    {
        $this->IdLiv = $IdLiv;

        return $this;
    }

    public function getIdUs(): ?User
    {
        return $this->IdUs;
    }

    public function setIdUs(?User $IdUs): static
    {
        $this->IdUs = $IdUs;

        return $this;
    }
}
