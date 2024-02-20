<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
   //nom
    #[ORM\Column(length: 255)]


   #[Assert\NotBlank(
       message: 'This field cannot be blank.'
   )]
   #[Assert\Regex(
    pattern: '/^[A-Za-zÀ-ÿ\s\-\'\']+$/',
    message: 'Invalid value format.'
)]
   #[Assert\Length(min: 3,
   minMessage: 'The name must be at least 3 characters long.".'
   )]
    private ?string $NomC = null;
//prenom
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
    message: 'This field cannot be blank.'
    )]
    private ?string $prenomC = null;
        //email
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'This field cannot be blank.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9._%+-]+@esprit\.tn$/',
        message: 'Please enter a valid email address ending with "@esprit.tn".'
    )]

    private ?string $email = null;
    
  //adresse
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'This field cannot be blank.'
    )]
  
    private ?string $adresse = null;
        ////    paytype
    #[ORM\Column(length: 255)]
    private ?string $TypePaiement = null;

    #[ORM\OneToOne] //(cascade: ['persist', 'remove']) pour button delete fonctionne
    private ?Commande $IdCommande = null;

    #[ORM\ManyToOne]
    private ?User $IdClient = null;

    #[ORM\ManyToOne]
    private ?User $IdLivreur = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }
    public function __toString()
    {
        return $this->getId(); 
    }
}
