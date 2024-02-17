<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomProduit = null;

    #[ORM\Column]
    private ?int $quantityP = null;

    #[ORM\Column]
    private ?float $prixProduit = null;

    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'produits')]
    private Collection $Commandes;

    public function __construct()
    {
        $this->Commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->NomProduit;
    }

    public function setNomProduit(string $NomProduit): static
    {
        $this->NomProduit = $NomProduit;

        return $this;
    }

    public function getQuantityP(): ?int
    {
        return $this->quantityP;
    }

    public function setQuantityP(int $quantityP): static
    {
        $this->quantityP = $quantityP;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): static
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->Commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->Commandes->contains($commande)) {
            $this->Commandes->add($commande);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        $this->Commandes->removeElement($commande);

        return $this;
    }
}
