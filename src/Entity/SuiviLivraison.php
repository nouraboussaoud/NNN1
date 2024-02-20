<?php

namespace App\Entity;

use App\Repository\SuiviLivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Commande $IDComm = null;

    #[ORM\ManyToOne(inversedBy: 'suiviLivraisons')]
    private ?User $IDUser = null;

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

    public function getIDComm(): ?Commande
    {
        return $this->IDComm;
    }

    public function setIDComm(?Commande $IDComm): static
    {
        $this->IDComm = $IDComm;

        return $this;
    }

    public function getIDUser(): ?User
    {
        return $this->IDUser;
    }

    public function setIDUser(?User $IDUser): static
    {
        $this->IDUser = $IDUser;

        return $this;
    }
}
