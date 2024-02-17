<?php

namespace App\Entity;

use App\Repository\CertifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertifRepository::class)]
class Certif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateReward = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Quiz $QuizReward = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $RewardUsers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReward(): ?\DateTimeInterface
    {
        return $this->dateReward;
    }

    public function setDateReward(\DateTimeInterface $dateReward): static
    {
        $this->dateReward = $dateReward;

        return $this;
    }

    public function getQuizReward(): ?Quiz
    {
        return $this->QuizReward;
    }

    public function setQuizReward(?Quiz $QuizReward): static
    {
        $this->QuizReward = $QuizReward;

        return $this;
    }

    public function getRewardUsers(): ?User
    {
        return $this->RewardUsers;
    }

    public function setRewardUsers(?User $RewardUsers): static
    {
        $this->RewardUsers = $RewardUsers;

        return $this;
    }
}
