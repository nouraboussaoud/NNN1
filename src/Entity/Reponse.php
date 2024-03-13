<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(length: 255)]
    private ?string $description_Rep = null;

    #[ORM\ManyToOne(inversedBy: 'Rec_Rep')]
    private ?Reclamation $Rep_Rec ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionRep(): ?string
    {
        return $this->description_Rep;
    }

    public function setDescriptionRep(string $description_Rep): static
    {
        $this->description_Rep = $description_Rep;

        return $this;
    }

    public function getRepRec(): ?Reclamation
    {
        return $this->Rep_Rec;
    }

    public function setRepRec(?Reclamation $Rep_Rec): static
    {
        $this->Rep_Rec = $Rep_Rec;

        return $this;
    }
}
