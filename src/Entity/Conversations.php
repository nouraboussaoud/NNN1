<?php

namespace App\Entity;

use App\Repository\ConversationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationsRepository::class)]
class Conversations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    private ?string $descC = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'conversations')]
    private Collection $UserConversation;

    #[ORM\OneToMany(mappedBy: 'conversations', targetEntity: Messagerie::class)]
    private Collection $ConvMes;

    public function __construct()
    {
        $this->UserConversation = new ArrayCollection();
        $this->ConvMes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescC(): ?string
    {
        return $this->descC;
    }

    public function setDescC(string $descC): static
    {
        $this->descC = $descC;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserConversation(): Collection
    {
        return $this->UserConversation;
    }

    public function addUserConversation(User $userConversation): static
    {
        if (!$this->UserConversation->contains($userConversation)) {
            $this->UserConversation->add($userConversation);
        }

        return $this;
    }

    public function removeUserConversation(User $userConversation): static
    {
        $this->UserConversation->removeElement($userConversation);

        return $this;
    }

    /**
     * @return Collection<int, Messagerie>
     */
    public function getConvMes(): Collection
    {
        return $this->ConvMes;
    }

    public function addConvMe(Messagerie $convMe): static
    {
        if (!$this->ConvMes->contains($convMe)) {
            $this->ConvMes->add($convMe);
            $convMe->setConversations($this);
        }

        return $this;
    }

    public function removeConvMe(Messagerie $convMe): static
    {
        if ($this->ConvMes->removeElement($convMe)) {
            // set the owning side to null (unless already changed)
            if ($convMe->getConversations() === $this) {
                $convMe->setConversations(null);
            }
        }

        return $this;
    }
}
