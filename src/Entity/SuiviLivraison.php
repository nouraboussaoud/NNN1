<?php

namespace App\Entity;

use App\Repository\SuiviLivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuiviLivraisonRepository::class)]
class SuiviLivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Livraison $IdLivraison = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateComm = null;

    #[ORM\Column(length: 255)]
    private ?string $localisatione = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLivraison(): ?Livraison
    {
        return $this->IdLivraison;
    }

    public function setIdLivraison(?Livraison $IdLivraison): static
    {
        $this->IdLivraison = $IdLivraison;

        return $this;
    }

    public function getDateComm(): ?\DateTimeInterface
    {
        return $this->dateComm;
    }

    public function setDateComm(\DateTimeInterface $dateComm): static
    {
        $this->dateComm = $dateComm;

        return $this;
    }

    public function getLocalisatione(): ?string
    {
        return $this->localisatione;
    }

    public function setLocalisatione(string $localisatione): static
    {
        $this->localisatione = $localisatione;

        return $this;
    }
}
