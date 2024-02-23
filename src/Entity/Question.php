<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

    /**
    * @Assert\NotBlank(message="Please write the question")
    */

    private ?string $text = null;
   
    #[ORM\Column(length: 255)]
    
    /**
    * @Assert\NotBlank(message="Please write the coorect choice")
    */
    private ?string $choix1 = null;

    #[ORM\Column(length: 255)]
     /**
    * @Assert\NotBlank(message="Please write the second choice")
    */
    private ?string $choix2 = null;

    #[ORM\Column(length: 255)]
     /**
    * @Assert\NotBlank(message="Please write the third choice")
    */
    private ?string $choix3 = null;

    #[ORM\Column(length: 255)]
     /**
    * @Assert\NotBlank(message="Please write the fourth choice")
    */
    private ?string $choix4 = null;

    #[ORM\Column]
      /**
    * @Assert\NotBlank(message="Please write the points")

    */
    private ?int $points = null;

    #[ORM\ManyToOne(inversedBy: 'Questions')]
    private ?Quiz $quiz = null;



    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getChoix1(): ?string
    {
        return $this->choix1;
    }

    public function setChoix1(string $choix1): static
    {
        $this->choix1 = $choix1;

        return $this;
    }

    public function getChoix2(): ?string
    {
        return $this->choix2;
    }

    public function setChoix2(string $choix2): static
    {
        $this->choix2 = $choix2;

        return $this;
    }

    public function getChoix3(): ?string
    {
        return $this->choix3;
    }

    public function setChoix3(string $choix3): static
    {
        $this->choix3 = $choix3;

        return $this;
    }

    public function getChoix4(): ?string
    {
        return $this->choix4;
    }

    public function setChoix4(string $choix4): static
    {
        $this->choix4 = $choix4;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }
}
