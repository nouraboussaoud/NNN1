<?php

namespace App\Entity;

use App\Repository\MessagerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagerieRepository::class)]
class Messagerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoie = null;

    #[ORM\ManyToOne(inversedBy: 'messageries')]
    private ?User $UserMessage = null;

    #[ORM\ManyToOne(inversedBy: 'ConvMes')]
    private ?Conversations $conversations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): static
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getUserMessage(): ?User
    {
        return $this->UserMessage;
    }

    public function setUserMessage(?User $UserMessage): static
    {
        $this->UserMessage = $UserMessage;

        return $this;
    }

    public function getConversations(): ?Conversations
    {
        return $this->conversations;
    }

    public function setConversations(?Conversations $conversations): static
    {
        $this->conversations = $conversations;

        return $this;
    }
}
