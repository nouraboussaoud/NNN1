<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
        /**
        * @Assert\NotBlank(message="Please write the coorect choice")
        * @Assert\Length(max=10, maxMessage="Your Quiz Name cannot be longer than {{ limit }} ")
        */
    private ?string $quizName = null;

    #[ORM\Column(length: 255)]
     /**
    * @Assert\NotBlank(message="Please write the coorect choice")
    */
    private ?string $descQuiz = null;

    #[ORM\Column(length: 255)]
     /**
    * @Assert\NotBlank(message="Please write the coorect choice")
    */
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class)]
    private Collection $Questions;


    

    
   

    #[ORM\Column]
     /**
    * @Assert\NotBlank(message="Please write the coorect choice")
    */
    private ?int $Points = null;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Certification::class, orphanRemoval: true)]
    private Collection $certification;

    public function __construct()
    {
        $this->Questions = new ArrayCollection();
        $this->certification = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizName(): ?string
    {
        return $this->quizName;
    }

    public function setQuizName(string $quizName): static
    {
        $this->quizName = $quizName;

        return $this;
    }

    public function getDescQuiz(): ?string
    {
        return $this->descQuiz;
    }

    public function setDescQuiz(string $descQuiz): static
    {
        $this->descQuiz = $descQuiz;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->Questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->Questions->contains($question)) {
            $this->Questions->add($question);
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->Questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

   

    public function getPoints(): ?int
    {
        return $this->Points;
    }

    public function setPoints(int $Points): static
    {
        $this->Points = $Points;

        return $this;
    }

    /**
     * @return Collection<int, Certification>
     */
    public function getCertification(): Collection
    {
        return $this->certification;
    }

    public function addCertification(Certification $certification): static
    {
        if (!$this->certification->contains($certification)) {
            $this->certification->add($certification);
            $certification->setQuiz($this);
        }

        return $this;
    }

    public function removeCertification(Certification $certification): static
    {
        if ($this->certification->removeElement($certification)) {
            // set the owning side to null (unless already changed)
            if ($certification->getQuiz() === $this) {
                $certification->setQuiz(null);
            }
        }

        return $this;
    }
}
