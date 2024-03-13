<?php

namespace App\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[Vich\Uploadable]
class Reclamation
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    
    private ?int $id = null;
   
    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="255")
     */

    private ?string $object = null;
    
    
 /**
     * @Assert\NotBlank(message="La description ne peut pas être vide.")
     * @Assert\Length(
     *     min=5,
     *     max=200,
     *     minMessage="La description doit avoir au moins {{ limit }} caractères.",
     *     maxMessage="La description ne peut pas dépasser {{ limit }} caractères."
     * )
     */


    #[ORM\Column(length: 255)]
     
    private ?string $description_Rec = null;
 /**
     * @Assert\NotBlank(message="La description ne peut pas être vide.")
     * @Assert\Length(
     *     
     *     max=200,
     *     
     *     maxMessage="La description ne peut pas dépasser {{ limit }} caractères."
     * )
     */
    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'Rep_Rec', targetEntity: Reponse::class)]
    private Collection $Rec_Rep;


    #[ORM\Column(length: 255 , nullable: false)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'reclamation_image' , fileNameProperty: 'imageName')]
    private ?File $imageFile = null;


    /**
 * @ORM\Column(type="datetime")
 */

private $updatedAt;


#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reclamations')]
#[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
private ?User $user = null;

// ...

public function getUser(): ?User
{
    return $this->user;
}

public function setUser(?User $user): static
{
    $this->user = $user;

    return $this;
}


    
    public function __construct()
    {
        $this->Rec_Rep = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): static
    {
        $this->object = $object;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->description_Rec;
    }

    

    public function setDescriptionRec(string $description_Rec): static
    {
        $this->description_Rec = $description_Rec;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

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
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        // Si l'image est définie, il est nécessaire de changer également la date de mise à jour pour que VichUploaderBundle fonctionne correctement.
        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    

    public function __toString(): string
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Reponse>
     */
    public function getRecRep(): Collection
    {
        return $this->Rec_Rep;
    }

    public function addRecRep(Reponse $recRep): static
    {
        if (!$this->Rec_Rep->contains($recRep)) {
            $this->Rec_Rep->add($recRep);
            $recRep->setRepRec($this);
        }

        return $this;
    }

    public function removeRecRep(Reponse $recRep): static
    {
        if ($this->Rec_Rep->removeElement($recRep)) {
            // set the owning side to null (unless already changed)
            if ($recRep->getRepRec() === $this) {
                $recRep->setRepRec(null);
            }
        }

        return $this;
    }
}
